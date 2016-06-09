<?php


namespace AitchKay\ISchema\Schema;

use Illuminate\Support\Collection;

class Index
{

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $columns;

    /**
     * @var boolean
     */
    protected $isUnique = false;

    /**
     * @var boolean
     */
    protected $isPrimary = false;


    /**
     * @param string $indexName
     * @param Collection $columns
     * @param boolean $isUnique
     * @param boolean $isPrimary
     */
    public function __construct($indexName, Collection $columns, $isUnique = false, $isPrimary = false)
    {
        $isUnique = $isUnique || $isPrimary;

        $this->setName($indexName);
        $this->isUnique = $isUnique;
        $this->isPrimary = $isPrimary;

        $this->setColumns($columns);


    }

    protected function setName($name){
        $this->name=$name;
    }

    /**
     * @return Collection
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param $columns Collection
     *
     * @return void
     *
     */
    protected function setColumns($columns)
    {
        $this->columns = $columns;
    }

    /**
     * Is the index neither unique nor primary key?
     *
     * @return boolean
     */
    public function isSimpleIndex()
    {
        return !$this->isPrimary && !$this->isUnique;
    }

    /**
     * @return boolean
     */
    public function isUnique()
    {
        return $this->isUnique;
    }

    /**
     * @return boolean
     */
    public function isUniqueAndNotPrimary()
    {
        return $this->isUnique and !$this->isPrimary;
    }


    /**
     * @return boolean
     */
    public function isPrimary()
    {
        return $this->isPrimary;
    }

    /**
     * @return boolean
     */

    public function isComposite()
    {
        return $this->columns->count() > 1;
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

    /**
     * todo
     * Checks if this index exactly spans the given column names in the correct order.
     *
     * @param array $columnNames
     *
     * @return boolean
     */
    public function spansColumns(array $columnNames)
    {

    }


}
