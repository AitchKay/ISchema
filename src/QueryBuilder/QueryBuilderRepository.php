<?php


namespace AitchKay\ISchema\QueryBuilder;


class QueryBuilderRepository
{

    /**
     * @var QueryBuilderInterface
     */
    private $builder;


    /**
     * @param QueryBuilderInterface $builder
     * QueryRepository constructor.
     */
    public function __construct(QueryBuilderInterface $builder)
    {
        $this->setBuilder($builder);
    }


    /**
     * @return QueryBuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @param QueryBuilderInterface $builder
     */
    public function setBuilder($builder)
    {
        $this->builder = $builder;
    }

    public function getTableColumnsQuery($table_schema, $table_name)
    {
        return $this->builder->getTableColumnsQuery($table_schema, $table_name);
    }

    public function getTableColumnQuery($table_schema, $table_name, $column_name)
    {
        return $this->builder->getTableColumnquery($table_schema, $table_name, $column_name);

    }


    public function getConstraintsQuery($table_schema, $table_name)
    {
        return $this->builder->getConstraintsQuery($table_schema, $table_name);

    }

    public function getReferencedConstraintsQuery($table_schema, $table_name)
    {
        return $this->builder->getReferencedConstraintsQuery($table_schema, $table_name);

    }

    public function getPrimaryKeyQuery($table_schema, $table_name)
    {
        return $this->builder->getPrimaryKeyQuery($table_schema, $table_name);

    }

    public function getUniqueKeyQuery($table_schema, $table_name)
    {
        return $this->builder->getUniqueKeyQuery($table_schema, $table_name);

    }

    public function getMulKeyQuery($table_schema, $table_name)
    {
        return $this->builder->getMulKeyQuery($table_schema, $table_name);

    }

    public function getReferringTablesQuery($table_schema, $table_name)
    {
        return $this->builder->getReferringTablesQuery($table_schema, $table_name);

    }

    public function getIndexesQuery($table_schema, $table_name)
    {
        return $this->builder->getIndexesQuery($table_schema, $table_name);


    }

    public function getTablesQuery($table_schema)
    {
        return $this->builder->getTablesQuery($table_schema);
    }


}