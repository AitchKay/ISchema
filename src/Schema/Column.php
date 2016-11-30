<?php


namespace AitchKay\ISchema\Schema;

use AitchKay\ISchema\Support\ArrayableTrait;
use AitchKay\ISchema\Support\Str;
use Illuminate\Contracts\Support\Arrayable;

class Column implements Arrayable
{
    use ArrayableTrait;

    public $table_catalog;
    public $table_schema;
    public $table_name;
    public $column_name;
    public $ordinal_position;
    public $column_default;
    public $is_nullable;
    public $data_type;
    public $character_maximum_length;
    public $character_octet_length;
    public $numeric_precision;
    public $numeric_scale;
    public $character_set_name;
    public $collation_name;
    public $column_type;
    public $column_key;
    public $extra;
    public $privileges;
    public $column_comment;

    public function getName()
    {
        return $this->column_name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->data_type;
    }

    /**
     * @return mixed
     */
    public function IsNullable()
    {
        return $this->is_nullable;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->ordinal_position;
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table_name;
    }

    /**
     * @return mixed
     */
    public function getDatabase()
    {
        return $this->table_schema;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->column_key;
    }

    /**
     * @return mixed
     */
    public function isPrimary()
    {
        return $this->column_key == 'PRI';
    }

    /**
     * @return mixed
     */
    public function isUnique()
    {
        return $this->column_key == 'UNI';
    }


    public function getFullyQuallifiedName()
    {
        return "$this->table_name.$this->column_name";
    }


    public function __call($name, $arguments)
    {
        $name = str_replace('get', '', $name);
        $name = Str::snake($name);
        if (property_exists($this, $name)) return $this->$name;
    }


}