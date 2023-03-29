<?php

include_once 'config.php';

class DatabaseWrapper
{
    private $databaseHost = DB_HOST;
    private $databaseUser = DB_USERNAME;
    private $databasePassword = DB_PASSWORD;
    private $databaseName = DB_DATABASE;
    public $database;

    public function __construct()
    {
        if (!isset($this->database)) {
            try {
                $databaseConnection = new PDO(
                    'pgsql:host=' .
                        $this->databaseHost .
                        ';dbname=' .
                        $this->databaseName,
                    $this->databaseUser,
                    $this->databasePassword
                );
                $databaseConnection->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
                $this->database = $databaseConnection;
            } catch (PDOException $e) {
                die('Falha ao conectar ao banco de dados: ' . $e->getMessage());
            }
        }
    }

    public function select($tableName, $conditions = [])
    {
        $query = 'SELECT ';
        $query .= array_key_exists('select', $conditions)
            ? $conditions['select']
            : '*';
        $query .= ' FROM ' . $tableName;

        if (array_key_exists('where', $conditions)) {
            $query .= ' WHERE ';
            $i = 0;
            foreach ($conditions['where'] as $key => $value) {
                $pre = $i > 0 ? ' AND ' : '';
                $query .= $pre . $key . " = '" . $value . "'";
                $i++;
            }
        }

        if (array_key_exists('order_by', $conditions)) {
            $query .= ' ORDER BY ' . $conditions['order_by'];
        }

        if (
            array_key_exists('start', $conditions) &&
            array_key_exists('limit', $conditions)
        ) {
            $query .= ' LIMIT ' . $conditions['start'] . ',' . $conditions['limit'];
        } elseif (
            !array_key_exists('start', $conditions) &&
            array_key_exists('limit', $conditions)
        ) {
            $query .= ' LIMIT ' . $conditions['limit'];
        }

        $query = $this->database->prepare($query);
        $query->execute();

        if (
            array_key_exists('return_type', $conditions) &&
            $conditions['return_type'] != 'all'
        ) {
            switch ($conditions['return_type']) {
                case 'count':
                    $dados = $query->rowCount();
                    break;
                case 'single':
                    $dados = $query->fetch(PDO::FETCH_ASSOC);
                    break;
                default:
                    $dados = [];
            }
        } else {
            if ($query->rowCount() > 0) {
                $dados = $query->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return $dados;
    }

    public function insert($tableName, $dados)
    {
        try {
            if (!empty($dados) && is_array($dados)) {
                $column = implode(',', array_keys($dados));
                $value = ':' . implode(',:', array_keys($dados));
                $query =
                    'INSERT INTO ' .
                    $tableName .
                    ' (' .
                    $column .
                    ') VALUES (' .
                    $value .
                    ')';

                $query = $this->database->prepare($query);

                foreach ($dados as $key => $val) {
                    $val = htmlspecialchars(strip_tags($val));
                    $query->bindValue(':' . $key, $val);
                }
                $insert = $query->execute();

                if ($insert) {
                    $dados['id'] = $this->database->lastInsertId();

                    return $dados;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    public function runCustomQuery($query)
    {
        $customQuery = $this->database->prepare($query);
        $customQuery->execute();

        $results = $customQuery->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }
}
