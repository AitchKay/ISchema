<?php


namespace AitchKay\ISchema\Schema;


use AitchKay\ISchema\Support\ArrayableTrait;
use AitchKay\ISchema\Support\Str;
use Illuminate\Contracts\Support\Arrayable;

class Constraint implements Arrayable
{
    use ArrayableTrait;

    public $constraint_catalog;
    public $constraint_schema;
    public $constraint_name;
    public $table_catalog;
    public $table_schema;
    public $table_name;
    public $column_name;
    public $ordinal_position;
    public $position_in_unique_constraint;
    public $referenced_table_schema;
    public $referenced_table_name;
    public $referenced_column_name;

    public function __call($name, $arguments)
    {
        $name = str_replace('get', '', $name);
        $name = Str::snake($name);
        if (property_exists($this, $name)) return $this->$name;
    }


}