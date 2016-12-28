<?php

namespace AitchKay\ISchema\Schema;

use AitchKay\ISchema\DAL\PDOWrapper;
use AitchKay\ISchema\QueryBuilder\InformationSchemaBuilder;
use AitchKay\ISchema\QueryBuilder\QueryBuilderRepository;
use PDO;

abstract class AbstractISchema
{
    /**
     * @var PDO
     */
    private $connection;
    /**
     * @var string
     */
    private $database;
    /**
     * @var PDOWrapper
     */
    private $db_service;

    /**
     * @var QueryBuilderRepository
     */
    protected $builder;

    /**
     * ISchema constructor.
     * @param PDO $connection
     * @param QueryBuilderRepository $builder
     */
    public function __construct(PDO $connection, QueryBuilderRepository $builder)
    {
        $this->setConnection($connection);
        $this->setDbService(new PDOWrapper($connection));
        $this->setDatabase();
        //todo resolve from ioc
        $this->builder = $builder;
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }



    /**
     * @param PDO $connection
     */
    protected function setConnection($connection)
    {
        $connection->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
        $this->connection = $connection;

    }


    /**
     * @return PDOWrapper
     */
    public function getDbService()
    {
        return $this->db_service;
    }

    /**
     * @param PDOWrapper
     */
    protected function setDbService($db_service)
    {
        $this->db_service = $db_service;
    }


    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     *
     * @return void
     */
    private function setDatabase()
    {
        $this->database = $this->getDbService()->query('select database()')->fetchColumn();;
        //sql server
        if(!$this->database) $this->database = $this->getDbService()->query('select DB_NAME()')->fetchColumn();;

    }

    public function getBuilder()
    {
        return $this->builder;
    }



}