<?php

namespace App\Objects;

class ObjectClass
{
    protected function jsonSeriable()
    {
        return get_object_vars($this);
    }
}
