<?php

namespace Glohm\ProcessoSeletivo\Model;

use Glohm\ProcessoSeletivo\Db;
use PDO;
use PDOException;

class EquipamentModel
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getConnection();
    }

    public function fetchEquiment()
    {
        try {
            $stmt = $this->db->query("SELECT 
            e.id AS equipamento_id,
            e.nome AS equipamento_nome,
            e.numero_serie,
            e.data_cadastro,
            t.id AS tipo_id,
            t.nome AS tipo_nome
        FROM equipamentos e
        JOIN tipos_equipamento t ON e.tipo_id = t.id;");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function fetchEquipmentById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT 
            e.id AS equipamento_id,
            e.nome AS equipamento_nome,
            e.numero_serie,
            e.data_cadastro,
            t.id AS tipo_id,
            t.nome AS tipo_nome
        FROM equipamentos e
        JOIN tipos_equipamento t ON e.tipo_id = t.id;");
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
            $stmt = $this->db->prepare("INSERT INTO equipamentos (nome, numero_serie, tipo_id, data_cadastro) VALUES (:nome, :numero_serie, :tipo_id, NOW())");
            $stmt->bindParam(":nome", $params['nome'], PDO::PARAM_STR);
            $stmt->bindParam(":numero_serie", $params['numero_serie'], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_id", $params['tipo_id'], PDO::PARAM_INT);
            $stmt->execute();
            return ["success" => "Equipamento inserido!", "id" => $this->db->lastInsertId()];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function update($params)
    {
        try {
            $stmt = $this->db->prepare("UPDATE equipamentos SET nome = :nome, numero_serie = :numero_serie, tipo_id = :tipo_id WHERE id = :id");
            $stmt->bindParam(":id", $params['id'], PDO::PARAM_INT);
            $stmt->bindParam(":nome", $params['nome'], PDO::PARAM_STR);
            $stmt->bindParam(":numero_serie", $params['numero_serie'], PDO::PARAM_STR);
            $stmt->bindParam(":tipo_id", $params['tipo_id'], PDO::PARAM_INT);
            $stmt->execute();
            return ["success" => "Equipamento atualizado!"];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM equipamentos WHERE id = :id");
            $stmt->bindParam(":id", $id[0], PDO::PARAM_INT);
            $stmt->execute();
            return ["success" => "Equipamento deletado!"];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
