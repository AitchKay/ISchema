<?php


namespace AitchKay\ISchema\QueryBuilder;


class InformationSchemaBuilder implements QueryBuilderInterface
{
    public function getTableColumnQuery($table_schema, $table_name, $column_name)
    {
        return $this->getTableColumnsquery($table_schema, $table_name) . " and COLUMN_NAME = '$column_name'";

    }

    public function getTableColumnsQuery($table_schema, $table_name)
    {
        return "Select * From INFORMATION_SCHEMA.COLUMNS Where TABLE_NAME = '$table_name' and TABLE_SCHEMA = '$table_schema'";

    }

    public function getConstraintsQuery($table_schema, $table_name)
    {
        return "Select * From information_schema.KEY_COLUMN_USAGE Where TABLE_NAME = '$table_name' and TABLE_SCHEMA = '$table_schema'";

    }

    public function getReferencedConstraintsQuery($table_schema, $table_name)
    {
        return "SELECT * FROM   information_schema.KEY_COLUMN_USAGE
                 WHERE   REFERENCED_TABLE_NAME = '$table_name'
                 and TABLE_SCHEMA = '$table_schema'";

    }

    public function getPrimaryKeyQuery($table_schema, $table_name)
    {
        return "Select COLUMN_NAME From INFORMATION_SCHEMA.COLUMNS
                  Where TABLE_NAME = '$table_name'
                  and TABLE_SCHEMA = '$table_schema'
                  and COLUMN_KEY = 'PRI'";

    }

    public function getUniqueKeyQuery($table_schema, $table_name)
    {
        return "Select COLUMN_NAME From INFORMATION_SCHEMA.COLUMNS
                  Where TABLE_NAME = '$table_name'
                  and TABLE_SCHEMA = '$table_schema'
                  and COLUMN_KEY = 'UNI'";

    }

    public function getMulKeyQuery($table_schema, $table_name)
    {
        return "Select COLUMN_NAME From INFORMATION_SCHEMA.COLUMNS
                  Where TABLE_NAME = '$table_name'
                  and TABLE_SCHEMA = '$table_schema'
                  and COLUMN_KEY = 'MUL'";

    }

    public function getReferringTablesQuery($table_schema, $table_name)
    {
        return "SELECT TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '$table_name' and TABLE_SCHEMA = '$table_schema'";


    }

    public function getIndexesQuery($table_schema, $table_name)
    {
        return "SELECT *
            FROM information_schema.statistics
            WHERE table_schema =  '$table_schema'
            AND table_name =  '$table_name'
            GROUP BY index_name, column_name
            ORDER BY index_name, seq_in_index";


    }

    public function getTablesQuery($table_schema)
    {
        return "SELECT table_name FROM information_schema.tables WHERE table_schema =  '$table_schema'";

    }


}