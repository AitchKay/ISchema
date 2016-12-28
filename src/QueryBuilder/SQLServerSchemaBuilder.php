<?php

/*
 * todo make compatible with sql_mode=only_full_group_by
 * */

namespace AitchKay\ISchema\QueryBuilder;


class SQLServerSchemaBuilder implements QueryBuilderInterface
{
    public function getTableColumnQuery($table_schema, $table_name, $column_name)
    {
        return $this->getTableColumnsquery($table_schema, $table_name) . " and COLUMN_NAME = '$column_name'";

    }

    public function getTableColumnsQuery($table_schema, $table_name)
    {
        return "Select * From INFORMATION_SCHEMA.COLUMNS Where TABLE_NAME = '$table_name' and TABLE_CATALOG = '$table_schema'";

    }

    public function getConstraintsQuery($table_schema, $table_name)
    {
        return "Select * From information_schema.KEY_COLUMN_USAGE Where TABLE_NAME = '$table_name' and TABLE_CATALOG = '$table_schema'";

    }

    public function getReferencedConstraintsQuery($table_schema, $table_name)
    {
        return "SELECT * FROM   information_schema.KEY_COLUMN_USAGE
                 WHERE   REFERENCED_TABLE_NAME = '$table_name'
                 and TABLE_CATALOG = '$table_schema'";

    }

    public function getFKConstraintsQuery($table_schema, $table_name){
       return  "   
        SELECT  
     KCU1.CONSTRAINT_NAME AS FK_CONSTRAINT_NAME 
    ,KCU1.TABLE_NAME AS FK_TABLE_NAME 
    ,KCU1.COLUMN_NAME AS FK_COLUMN_NAME 
    ,KCU1.ORDINAL_POSITION AS FK_ORDINAL_POSITION 
    ,KCU2.CONSTRAINT_NAME AS REFERENCED_CONSTRAINT_NAME 
    ,KCU2.TABLE_NAME AS REFERENCED_TABLE_NAME 
    ,KCU2.COLUMN_NAME AS REFERENCED_COLUMN_NAME 
    ,KCU2.ORDINAL_POSITION AS REFERENCED_ORDINAL_POSITION 
    FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS AS RC 
    
    INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KCU1 
        ON KCU1.CONSTRAINT_CATALOG = RC.CONSTRAINT_CATALOG  
        AND KCU1.CONSTRAINT_SCHEMA = RC.CONSTRAINT_SCHEMA 
        AND KCU1.CONSTRAINT_NAME = RC.CONSTRAINT_NAME 
        AND FK_TABLE_NAME = '$table_name'
        AND KCU1.TABLE_CATALOG = '$table_schema'
    INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KCU2 
        ON KCU2.CONSTRAINT_CATALOG = RC.UNIQUE_CONSTRAINT_CATALOG  
        AND KCU2.CONSTRAINT_SCHEMA = RC.UNIQUE_CONSTRAINT_SCHEMA 
        AND KCU2.CONSTRAINT_NAME = RC.UNIQUE_CONSTRAINT_NAME 
        AND KCU2.ORDINAL_POSITION = KCU1.ORDINAL_POSITION
            ";
    }

    public function getPrimaryKeyQuery($table_schema, $table_name)
    {

        return  "SELECT COLUMN_NAME 
                    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS TC
                    INNER JOIN
                    INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KU
                    ON TC.CONSTRAINT_TYPE = 'PRIMARY KEY' AND
                        TC.CONSTRAINT_NAME = KU.CONSTRAINT_NAME
                        and ku.table_name='$table_name' and ku.table_catalog = '$table_schema'
                    ORDER BY KU.TABLE_NAME, KU.ORDINAL_POSITION";



    }

    public function getUniqueKeyQuery($table_schema, $table_name)
    {
        return "Select COLUMN_NAME From INFORMATION_SCHEMA.COLUMNS
                  Where TABLE_NAME = '$table_name'
                  and TABLE_CATALOG = '$table_schema'
                  and COLUMN_KEY = 'UNI'";

    }

    public function getMulKeyQuery($table_schema, $table_name)
    {
        return "Select COLUMN_NAME From INFORMATION_SCHEMA.COLUMNS
                  Where TABLE_NAME = '$table_name'
                  and TABLE_CATALOG = '$table_schema'
                  and COLUMN_KEY = 'MUL'";

    }

    public function getReferringTablesQuery($table_schema, $table_name)
    {
        return "SELECT TABLE_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE REFERENCED_TABLE_NAME = '$table_name' and TABLE_CATALOG = '$table_schema'";


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
        return "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_CATALOG='".$table_schema."'";

    }


}