<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class BoolType extends ScalarType
{
    public function validate($value)
    {
        if (!is_bool($value)) {
            throw new InvalidTypeException('Value type is not bool.');
        }
    }
}
