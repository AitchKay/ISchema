<?php


namespace AitchKay\ISchema;
use AitchKay\ISchema\QueryBuilder\InformationSchemaBuilder;
use AitchKay\ISchema\QueryBuilder\QueryBuilderRepository;
use AitchKay\ISchema\QueryBuilder\SQLServerSchemaBuilder;


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
            if($connection->getDriver()=='sqlsrv') {
                $builder = new QueryBuilderRepository(new SQLServerSchemaBuilder());
            }
            else $builder = new QueryBuilderRepository(new InformationSchemaBuilder());

            return new Schema\ISchema($connection->getPdo(),$builder);
        } else if (is_array($connection)) {

            if (!isset($connection['host'])) $connection['host'] = 'localhost';

            if (isset($connection['driver']) and isset($connection['database'])
                and isset($connection['username']) and isset($connection['password'])
            ) {

                return static::create(new DAL\PDOConnection($connection['driver'],
                    $connection['host'], $connection['database'], $connection['username'], $connection['password']));
            }
        } else return false;


    }
}
