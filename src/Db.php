<?php

namespace Glohm\ProcessoSeletivo;

use PDO;
use PDOException;
use Exception;

class Db
{
    private static ?Db $instance = null;
    private ?PDO $connection = null;

    private string $host = '';
    private string $port = '';
    private string $dbname = '';
    private string $user = '';
    private string $password = '';

    private function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname}";
            $this->connection = new PDO($dsn, $this->user, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false,
            ]);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }
}
