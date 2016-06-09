<?php


namespace AitchKay\ISchema\Schema;


use AitchKay\ISchema\Support\ArrayableTrait;

class ForeignKey
{
    use ArrayableTrait;
    public $table;
    public $referenced_table;
    public $column;
    public $referenced_column;
    public $constraint;

    /**
     * ForeignKey constructor.
     * @param $table
     * @param $column_name
     */
    public function __construct($constraint, $table, $column, $referenced_table, $refrenced_column)
    {
        $this->setConstraint($constraint);
        $this->setColumn($column);
        $this->setTable($table);
        $this->setReferencedTable($referenced_table);
        $this->setReferencedColumn($refrenced_column);
    }


    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param mixed $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * @return mixed
     */
    public function getConstraint()
    {
        return $this->constraint;
    }

    /**
     * @param mixed $constraint
     */
    public function setConstraint($constraint)
    {
        $this->constraint = $constraint;
    }


    /**
     * @return mixed
     */
    public function getReferencedTable()
    {
        return $this->referenced_table;
    }

    /**
     * @param mixed $referenced_table
     */
    public function setReferencedTable($referenced_table)
    {
        $this->referenced_table = $referenced_table;
    }


    /**
     * @return mixed
     */
    public function getReferencedColumn()
    {
        return $this->referenced_column;
    }

    /**
     * @param mixed $referenced_column
     */
    public function setReferencedColumn($referenced_column)
    {
        $this->referenced_column = $referenced_column;
    }
}