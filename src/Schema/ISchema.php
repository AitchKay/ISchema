<?php


namespace AitchKay\ISchema\Schema;

use Illuminate\Support\Collection;

/**
 * Class ISchema
 * @package AitchKay\ISchema\Schema
 */
class ISchema extends AbstractISchema
{
    /**
     * @var \Illuminate\Support\Collection | null
     */
    protected $tables;

    /**
     * @return string[]
     */
    public function listTables()
    {
        $query = $this->builder->getTablesQuery($this->getDatabase());
        return $this->getDbService()->query($query)->lists();
    }

    /**
     * @param string $table
     * @return Table|null
     */
    public function getTable($table)
    {
        if (!$this->tables) $this->setTables();
        return $this->getTables()->get($table);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getTables()
    {

        if (!$this->tables) $this->setTables();

        return $this->tables;
    }

    public function setTables()
    {

        if (!$this->tables) {
            $tables = $this->listTables();
            $a_tables = [];
            foreach ($tables as $table) {
                $a_tables[$table] = new Table($this, $table);
            }
            $tables = new Collection($a_tables);
            $this->tables = $tables;


        }

        return $this;
    }

    /**
     * @param string $table
     * @return boolean
     */
    public function hasTable($table)
    {
        if (!$this->tables) $this->setTables();
        return $this->getTables()->has($table);
    }


}