<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class ArrayType extends IterableType
{
    public function validate($value)
    {
        if (!is_array($value)) {
            throw new InvalidTypeException('Value type is not array.');
        }
    }
}
