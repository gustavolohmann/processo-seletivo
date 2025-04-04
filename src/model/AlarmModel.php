<?php
namespace Glohm\ProcessoSeletivo\Model;

use Glohm\ProcessoSeletivo\Db;
use PDO;
use PDOException;

class AlarmModel
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function fetchAlarm()
    {
        try {
            $stmt = $this->db->query("SELECT 
                al.id,
                al.descricao AS descricao_alarme,
                al.data_cadastro,
                cls.nome AS classificacao_alarme,
                eq.nome AS equipamento_nome,
                sl.status
            FROM alarmes AS al 
            LEFT JOIN classificacoes AS cls 
                ON al.classificacao_id = cls.id
            LEFT JOIN equipamentos AS eq 
                ON al.equipamento_id = eq.id
            LEFT JOIN (
                SELECT s1.*
                FROM alarmes_atuados s1
                INNER JOIN (
                    SELECT 
                        alarme_id, 
                        MAX(data_entrada) AS max_data,
                        MAX(id) AS max_id  
                    FROM alarmes_atuados
                    GROUP BY alarme_id
                ) s2 ON s1.alarme_id = s2.alarme_id 
                    AND s1.data_entrada = s2.max_data
                    AND s1.id = s2.max_id  
            ) sl ON al.id = sl.alarme_id");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function fetchAlarmById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT 
                al.id,
                al.descricao AS descricao_alarme,
                al.data_cadastro,
                cls.nome AS classificacao_alarme,
                eq.nome AS equipamento_nome,
                sl.status
            FROM alarmes AS al 
            LEFT JOIN classificacoes AS cls 
                ON al.classificacao_id = cls.id
            LEFT JOIN equipamentos AS eq 
                ON al.equipamento_id = eq.id
            LEFT JOIN (
                SELECT s1.*
                FROM alarmes_atuados s1
                INNER JOIN (
                    SELECT 
                        alarme_id, 
                        MAX(data_entrada) AS max_data,
                        MAX(id) AS max_id  
                    FROM alarmes_atuados
                    GROUP BY alarme_id
                ) s2 ON s1.alarme_id = s2.alarme_id 
                    AND s1.data_entrada = s2.max_data
                    AND s1.id = s2.max_id  
            ) sl ON al.id = sl.alarme_id WHERE al.id = :id");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function insert($params)
    {

        try {
            $stmt = $this->db->prepare("
            INSERT INTO alarmes (descricao, classificacao_id, data_cadastro, equipamento_id) 
            VALUES (:descricao, :classificacao_id, NOW(), :equipamento_id)
        ");

            $stmt->bindParam(":descricao", $params['descricao'], PDO::PARAM_STR);
            $stmt->bindParam(":classificacao_id", $params['classificacao_id'], PDO::PARAM_INT);
            $stmt->bindParam(":equipamento_id", $params['equipamento_id'], PDO::PARAM_INT);

            $stmt->execute();

            return [
                "success" => "Alarme inserido!",
                "id" => $this->db->lastInsertId()
            ];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function fetchActuatedAlarm()
    {
        try {
            $stmt = $this->db->prepare("
            SELECT 
                aa.*,
                a.descricao AS nome_alarme,
                COUNT(aa.alarme_id) OVER (PARTITION BY aa.alarme_id) AS quantidade_uso
            FROM 
                alarmes_atuados aa
            JOIN 
                alarmes a ON aa.alarme_id = a.id
            ORDER BY 
                aa.data_entrada DESC
        ");

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'success' => true,
                'data' => $result,
                'count' => count($result)
            ];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ];
        }
    }
    public function insertActuatedAlarm($params)
    {

        try {
            $stmtCheck = $this->db->prepare("
            SELECT id FROM alarmes_atuados 
            WHERE alarme_id = :alarme_id AND status = 'Ativo'
            ORDER BY id DESC LIMIT 1
        ");
            $stmtCheck->bindParam(":alarme_id", $params['alarme_id'], PDO::PARAM_INT);
            $stmtCheck->execute();
            $existingAlarm = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($params['status'] === 'Ativo') {
                $stmtInsert = $this->db->prepare("
                INSERT INTO alarmes_atuados (alarme_id, data_entrada, status)
                VALUES (:alarme_id, NOW(), 'Ativo')
            ");
                $stmtInsert->bindParam(":alarme_id", $params['alarme_id'], PDO::PARAM_INT);
                $stmtInsert->execute();

                return [
                    "success" => true,
                    "message" => "Alarme ativado!",
                    "id" => $this->db->lastInsertId()
                ];
            } else {
                if ($existingAlarm) {
                    $stmtUpdate = $this->db->prepare("
                    UPDATE alarmes_atuados 
                    SET data_saida = NOW(), status = 'Inativo' 
                    WHERE id = :id
                ");
                    $stmtUpdate->bindParam(":id", $existingAlarm['id'], PDO::PARAM_INT);
                    $stmtUpdate->execute();

                    return [
                        "success" => true,
                        "message" => "Alarme desativado!"
                    ];
                }
                return [
                    "success" => false,
                    "message" => "Nenhum alarme ativo encontrado para desativar."
                ];
            }
        } catch (PDOException $e) {
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }

    public function update($params)
    {
        try {
            $stmt = $this->db->prepare("UPDATE alarmes SET descricao = :descricao, classificacao_id = :classificacao_id, equipamento_id = :equipamento_id WHERE id = :id");
            $stmt->bindParam(":id", $params['id'], PDO::PARAM_INT);
            $stmt->bindParam(":descricao", $params['descricao'], PDO::PARAM_STR);
            $stmt->bindParam(":classificacao_id", $params['classificacao_id'], PDO::PARAM_INT);
            $stmt->bindParam(":equipamento_id", $params['equipamento_id'], PDO::PARAM_INT);
            $stmt->execute();
            return ["success" => "Alarme atualizado!"];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM alarmes WHERE id = :id");
            $stmt->bindParam(":id", $id[0], PDO::PARAM_INT);
            $stmt->execute();
            return ["success" => "Alarme deletado!"];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
