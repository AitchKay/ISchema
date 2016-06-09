<?php

namespace AitchKay\ISchema\QueryBuilder;


interface QueryBuilderInterface
{
    public function getTableColumnsQuery($table_schema, $table_name);

    public function getTableColumnQuery($table_schema, $table_name, $column_name);

    public function getConstraintsQuery($table_schema, $table_name);

    public function getReferencedConstraintsQuery($table_schema, $table_name);

    public function getPrimaryKeyQuery($table_schema, $table_name);

    public function getUniqueKeyQuery($table_schema, $table_name);

    public function getMulKeyQuery($table_schema, $table_name);

    public function getReferringTablesQuery($table_schema, $table_name);

    public function getIndexesQuery($table_schema, $table_name);

    public function getTablesQuery($table_schema);

}