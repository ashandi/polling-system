<?php

namespace System;

use PDO;
use PDOStatement;
use ReflectionMethod;

class QueryBuilder
{

    /**
     * @var string
     */
    private $modelName;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * @param string $modelName
     */
    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;

        $this->connection = $this->connect();
    }

    /**
     * Method establishes connection to database
     *
     * @return PDO
     */
    protected function connect() : PDO
    {
        $driver = config('db_driver');
        $host = config('db_host');
        $database = config('db_name');
        $dsn = "$driver:dbname=$database;host=$host";

        $user = config('db_user');
        $password = config('db_password');

        return new PDO($dsn, $user, $password);
    }

    /**
     * Generic method for making queries to database
     *
     * @param string $query
     * @return PDOStatement
     */
    public function execute(string $query) : PDOStatement
    {
        return $this->connection->query($query);
    }

    /**
     * Method makes query to database and converts result to exemplar of Model class
     *
     * @param string $query
     * @return null|object
     */
    public function executeOne(string $query)
    {
        $statement = $this->connection->query($query);
        $queryResults = $statement->fetchAll(PDO::FETCH_ASSOC);

        return count($queryResults) == 1
            ? $this->createModel($queryResults[0])
            : null;
    }

    /**
     * Method makes query to database and converts result to array with exemplars of Model class
     *
     * @param string $query
     * @return array
     */
    public function executeArray(string $query) : array
    {
        $statement = $this->connection->query($query);
        if (!$statement) {
            return [];
        }

        $queryResults = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $this->createArrayOfModels($queryResults);
    }

    /**
     * Method for converting results of database query to array with exemplars of Model class
     *
     * @param array $queryResults
     * @return array
     */
    private function createArrayOfModels(array $queryResults) : array
    {
        $method = new ReflectionMethod($this->modelName, 'createFromArray');

        $models = array_map(function ($modelParams) use ($method) {
            return $this->createModel($modelParams, $method);
        }, $queryResults);

        return $models;
    }

    /**
     * Method for converting result of database query to exemplar of Model class
     *
     * @param array $modelParams
     * @param ReflectionMethod|null $method
     * @return mixed
     */
    private function createModel(array $modelParams, ReflectionMethod $method = null)
    {
        if (empty($method)) {
            $method = new ReflectionMethod($this->modelName, 'createFromArray');
        }

        return $method->invoke(null, $modelParams);
    }

    /**
     * Method returns id of last inserted record
     *
     * @return int
     */
    public function getLastInsertedId() : int
    {
        return $this->connection->lastInsertId();
    }

}