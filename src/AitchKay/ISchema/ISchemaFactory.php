<?php


namespace AitchKay\ISchema;


/**
 * Class ISchemaFactory
 * @package AitchKay\ISchema
 * todo add ioc container and define resolvables
 */
class ISchemaFactory
{


    static function create($connection)
    {
        if ($connection instanceof DAL\PDOInterface) {
            $pdo = $connection->getPdo();
            return new Schema\ISchema($pdo);
        } else if (is_array($connection)) {

            if (!isset($connection['host'])) $connection['host'] = 'localhost';

            if (isset($connection['driver']) and isset($connection['database'])
                and isset($connection['user']) and isset($connection['password'])
            ) {

                return static::create(new DAL\PDOConnection($connection['driver'],
                    $connection['host'], $connection['database'], $connection['user'], $connection['password']));
            }
        } else return false;


    }
}