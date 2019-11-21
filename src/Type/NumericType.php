<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class NumericType extends ScalarType
{
    public function validate($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidTypeException('Value type is not numeric.');
        }
    }
}
