<?php


namespace AitchKay\ISchema\Support;


trait ArrayableTrait
{
    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }
}