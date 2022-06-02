<?php

namespace app\services;

use app\traits\SingleTone;

class DataBase
{
    use SingleTone;

    private array $config;

    private ?\PDO $connection = null;

    public function __construct()
    {
        $this->config = include $_SERVER['DOCUMENT_ROOT'] . "../config/main.php";
        // die();
    }

    protected function getConnection(): ?\PDO
    {
        if (is_null($this->connection)) {
            $this->connection = new \PDO(
                $this->buildDsn(),
                $this->config['components']['db']['user'],
                $this->config['components']['db']['password']
            );

            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        return $this->connection;
    }

    private function buildDsn(): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            $this->config['components']['db']['driver'],
            $this->config['components']['db']['host'],
            $this->config['components']['db']['database'],
            $this->config['components']['db']['charset']
        );
    }

    public function query(string $sql, array $params = [])
    {
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    public function queryOne(string $sql, array $params = [])
    {
        return $this->queryAll($sql, $params)[0];
    }

    public function queryAll(string $sql, array $params = [], string $className = null)
    {
        $pdoStatement = $this->query($sql, $params);
        if (isset($className)) {
            $pdoStatement->setFetchMode(
                \PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,
                $className
            );
        }
        return $pdoStatement->fetchAll();
    }

    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function getLastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }
}
