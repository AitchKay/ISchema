<?php
namespace AitchKay\ISchema\Schema;

use Illuminate\Support\Collection;
use PDO;

/**
 * Class Table
 * todo ioc, serialize ,auto increment
 * @package AitchKay\ISchema\Schema
 */
class Table extends AbstractISchema
{

    /**
     * @var string
     */
    public $name;
    /**
     * @var Collection;
     */
    protected $columns;

    /**
     * @var Collection;
     */
    protected $constraints;

    /**
     * @var Collection;
     */
    protected $referenced_constraints;

    /**
     * @var Collection;
     */
    protected $indexes;

    /**
     * @var Collection;
     */

    protected $foreign_keys;


    /**
     * Table constructor.
     * todo resolve dependencies through ioc remove pdo;
     * @param PDO $connection
     * @param $name string
     */
    public function __construct(PDO $connection, $name)
    {
        $this->name = $name;
        parent::__construct($connection);
        $this->setColumns();
    }


    public function getColumns()
    {
        return $this->columns;
    }

    protected function setColumns()
    {
        $query = $this->builder->getTableColumnsQuery($this->getDatabase(), $this->name);
        $this->columns = new Collection($this->getDbService()->query($query)->fetchAllClass('AitchKay\ISchema\Schema\Column'));
    }

    public function listColumns()
    {
        return $this->getColumns()->lists('column_name')->all();

    }

    public function hasColumn($column_name){
        return $this->getColumns()->contains('column_name',$column_name);
    }

    /**
     *
     * @param string $column_name
     * @param integer $pos
     *
     * @return boolean
     */
    public function hasColumnAtPosition($column_name, $pos = 0)
    {
        $column = $this->getColumns()->offsetGet($pos);
        if($column and $column->column_name == $column_name ) return true;

        return false;
    }

    public function getColumn($name)
    {
        $query = $this->builder->getTableColumnQuery($this->getDatabase(), $this->name, $name);

        return $this->getDbService()->query($query)->fetchClass('AitchKay\ISchema\Schema\Column');
    }

    public function getConstraints()
    {
        $query = $this->builder->getConstraintsQuery($this->getDatabase(), $this->name);

        return new Collection($this->getDbService()->query($query)->fetchAllClass('AitchKay\ISchema\Schema\Constraint'));
    }

    public function getReferencedConstraints()
    {
        $query = $this->builder->getReferencedConstraintsQuery($this->getDatabase(), $this->name);
        return new Collection($this->getDbService()->query($query)->fetchAllClass('AitchKay\ISchema\Schema\Constraint'));
    }

    public function getForeignKeyConstraints()
    {

        return $this->getConstraints()->filter(
            function ($constraint) {
                return !empty($constraint->referenced_table_name)
                and !empty($constraint->referenced_column_name);
            });
    }

    public function getForeignKeys()
    {
        $foreign_constraints = $this->getForeignKeyConstraints();

        $foreign_keys = [];

        $foreign_constraints->each(function ($constraint) use (&$foreign_keys) {
            $column = $this->getColumn($constraint->column_name);
            $foreign_table = new static($this->getConnection(), $constraint->referenced_table_name);
            $foreign_column = $foreign_table->getColumn($constraint->referenced_column_name);
            $foreign_keys[] = new ForeignKey($constraint, $this, $column, $foreign_table, $foreign_column);
        });

        return new Collection($foreign_keys);

    }

    public function getForeignKeysTables()
    {

        return $this->getForeignKeys()->lists('referenced_table');

    }

    public function getPrimaryIndex()
    {
       return $this->getIndexes()->first(function($i,$index){return $index->isPrimary();});
    }

    public function getReferringTables()
    {
        $query = $this->builder->getReferringTablesQuery($this->getDatabase(), $this->name);
        $names = $this->getDbService()->query($query)->lists();
        $collection = new Collection();

        foreach ($names as $name) {
            $collection->push(new static($this->getConnection(), $name));
        }

        return $collection;
    }

    public function getReferringColumns()
    {
        $constraints=$this->getReferencedConstraints();

        $columns = new Collection();

        $tables=$this->getReferringTables();

        foreach ($constraints as $constraint){
            $table = $tables->first(function($i,$table)use($constraint){

                return $table->name == $constraint->table_name;
            });
            $columns->push($table->getColumn($constraint->column_name));
        }

        return $columns;

    }

    public function getRawIndexes()
    {
        $query = $this->builder->getIndexesQuery($this->getDatabase(), $this->name);
        return new Collection($this->getDbService()->query($query)->fetchAllAssoc());

    }

    public function getIndexes()
    {
       $raw_indexes = $this->getRawIndexes()->groupBy('index_name');
        $indexes = new Collection();
        $raw_indexes->each(function($collection)use($indexes){
            $columns = new Collection();

            $collection->each(function($index_column)use ($columns){
                    $columns->push($this->getColumn($index_column['column_name']));

            });
            $foreign_keys=$this->getForeignKeyConstraints()->lists('column_name')->all();
            if(!in_array($collection->first()['column_name'],$foreign_keys)) {
                $is_unique = !$collection->first()['non_unique'];
                $is_primary = $columns->first()->column_key=='PRI';
                $index = new Index($collection->first()['index_name'],$columns,$is_unique,$is_primary);
                $indexes->push($index);
            }


        });

        return $indexes;

    }

    /**
     *  If a table has at least two foreign keys
     *  and it's name is composed two referenced tables
     *  names separated by an underscore.
     * @return bool
     */
    public function isPivot()
    {

        $foreign_tables=$this->getForeignKeysTables()->lists('name')->all();

        foreach ($foreign_tables as $iTable){
            foreach ($foreign_tables as $kTable){
                if( in_array($this->name,[$iTable.'_'.$kTable,$kTable.'_'.$iTable])) return true;
            }
        }

        return false;
    }

}