<?php

namespace Craft\Orm;

trait Model
{

    /**
     * Get entity
     * @return CandyInterface
     */
    public static function get()
    {
        return Syn::get(static::entity());
    }


    /**
     * Get many entities
     * @param array $where
     * @param null $sort
     * @param null $limit
     * @return self[]
     */
    public static function all(array $where = [], $sort = null, $limit = null)
    {
        return Syn::all(static::entity(), $where, $sort, $limit);
    }


    /**
     * Get one entities
     * @param array $where
     * @return self
     */
    public static function one(array $where = [])
    {
        return Syn::one(static::entity(), $where);
    }


    /**
     * Save entity
     * @param $data
     * @return self
     */
    public static function save($data)
    {
        return Syn::save(static::entity(), $data);
    }


    /**
     * Drop entity
     * @param $id
     * @return int
     */
    public static function drop($id)
    {
        return Syn::drop(static::entity(), $id);
    }


    /**
     * Alias of ::get()
     * @return CandyInterface
     */
    public static function query()
    {
        return Syn::get(static::entity());
    }


    /**
     * Get entity name
     * @return string
     */
    protected static function entity()
    {
        static $name;

        if(!$name) {
            $ns = explode('\\', get_called_class());
            $name = strtolower(end($ns));
        }

        return $name;
    }


    /**
     * Many relation
     * @param $entity
     * @param $foreign
     * @param string $local
     * @return mixed
     */
    protected function _many($entity, $foreign, $local = 'id')
    {
        return Syn::get($entity)->where($foreign, $this->{$local})->all();
    }


    /**
     * One relation
     * @param $entity
     * @param $local
     * @param string $foreign
     * @return mixed
     */
    protected function _one($entity, $local, $foreign = 'id')
    {
        return Syn::get($entity)->where($foreign, $this->{$local})->one();
    }

} 