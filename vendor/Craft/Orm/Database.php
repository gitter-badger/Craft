<?php

/**
 * This file is part of the Craft package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the Licence.txt
 * file that was distributed with this source code.
 */
namespace Craft\Orm;

use Craft\Debug\Logger;

class Database
{

    /** @var \PDO */
    protected $pdo;

    /** @var Database\Entity[] */
    protected $entities = [];

    /** @var Database\Builder */
    protected $builder;


    /**
     * Init base with pdo
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->builder = new Database\Builder;
    }


    /**
     * Get pdo instance
     * @return \PDO
     */
    public function pdo()
    {
        return $this->pdo;
    }


    /**
     * Map entities
     * @param $entities
     * @return $this
     */
    public function map(...$entities)
    {
        foreach($entities as $entity) {
            $this->entities[$entity] = new Database\Entity($this, $entity);
            Logger::info('Entity ' . $entity . ' mapped in database');
        }

        return $this;
    }


    /**
     * User custom query
     * @param string $sql
     * @param array $data
     * @param string $entity
     * @throws \PDOException
     * @return int|object[]
     */
    public function query($sql, array $data = [], $entity = null)
    {
        // check query
        $stm = $this->pdo->prepare($sql);
        if(!$stm) {
            throw new \PDOException($stm->errorInfo());
        }

        // execute
        $stm->execute($data);

        // select type
        if($stm->columnCount()) {
            return $entity
                ? $stm->fetchAll(\PDO::FETCH_CLASS, $entity)
                : $stm->fetchAll(\PDO::FETCH_OBJ);
        }

        // exec type
        return $stm->rowCount();
    }


    /**
     * Get entity mapper
     * @param string $entity
     * @return Database\Entity
     */
    public function get($entity)
    {
        // create entity
        if(!isset($this->entities[$entity])) {
            $this->entities[$entity] = new Database\Entity($this, $entity);
        }

        return $this->entities[$entity];
    }


    /**
     * Build entities
     * @return bool
     */
    public function build()
    {
        $valid = true;

        // create entities
        foreach(array_keys($this->entities) as $entity) {

            // create query
            $sql = $this->builder->create($entity);

            // execute query
            $valid &= $this->query($sql);
        }

        Logger::info('Database schema built');
        return $valid;
    }


    /**
     * Clear entity data
     * @param string $entity
     * @return int
     */
    public function clear($entity)
    {
        // create query
        $sql = $this->builder->clear($entity);

        // execute query
        return $this->query($sql);
    }


    /**
     * Destruct entity
     * @param $entity
     * @return int
     */
    public function wipe($entity)
    {
        // create query
        $sql = $this->builder->wipe($entity);

        // execute query
        return $this->query($sql);
    }

} 