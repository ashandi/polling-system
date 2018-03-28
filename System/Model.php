<?php

namespace System;

abstract class Model
{

    /**
     * @var string
     */
    protected $table;

    /**
     * Method returns primary key of this model
     *
     * @return string
     */
    public function getPrimaryKey() : string
    {
        return 'id';
    }

    /**
     * Method creates new exemplar of QueryBuilder
     *
     * @return QueryBuilder
     */
    public function newQuery()
    {
        return new QueryBuilder(static::class);
    }

    /**
     * Method allows us to call methods of queryBuilder from model
     *
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function __call(string $name, array $args)
    {
        return $this->newQuery()->$name(...$args);
    }

    /**
     * Method creates exemplar of Model from array of params
     *
     * @param array $params
     * @return static
     */
    public static function createFromArray(array $params)
    {
        $model = new static();
        foreach ($params as $paramName => $paramValue) {
            $model->$paramName = $paramValue;
        }

        return $model;
    }

    /**
     * Method defines order of saving exemplar of model in database
     */
    public abstract function save() : void;

    /**
     * Method deletes record in database
     */
    public function delete() : void
    {
        $primaryKey = $this->getPrimaryKey();

        $this->newQuery()
            ->execute("DELETE FROM {$this->table} WHERE `$primaryKey` = {$this->$primaryKey}");
    }

    /**
     * Method returns array of objects related with this by "one to many" scheme
     *
     * @param string $className
     * @param string $foreignKey
     * @return array
     */
    public function hasMany(string $className, string $foreignKey) : array
    {
        $relatedClass = new $className();
        $primaryKey = $this->getPrimaryKey();

        return $relatedClass
            ->executeArray("SELECT {$relatedClass->table}.* " .
                "FROM {$relatedClass->table} WHERE $foreignKey = '{$this->$primaryKey}'");
    }

    /**
     * Method returns array of objects related with this by "one to many" scheme
     * throw another "one to many" relation
     *
     * @param string $className
     * @param string $throughClassName
     * @param string $foreignKey
     * @param string $throughForeignKey
     * @return array
     */
    public function hasManyThrow(
        string $className,
        string $throughClassName,
        string $foreignKey,
        string $throughForeignKey
    ) : array {
        $relatedClass = new $className();
        $throughClass = new $throughClassName();

        $primaryKey = $this->getPrimaryKey();
        $throughPrimaryKey = $throughClass->getPrimaryKey();

        return $relatedClass
            ->executeArray("SELECT {$relatedClass->table}.* " .
                " FROM {$relatedClass->table} JOIN {$throughClass->table} " .
                " ON {$relatedClass->table}.$throughForeignKey = {$throughClass->table}.$throughPrimaryKey" .
                " WHERE {$throughClass->table}.$foreignKey = '{$this->$primaryKey}'");
    }

}