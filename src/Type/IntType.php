<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class IntType extends NumericType
{
    public function validate($value)
    {
        if (!is_int($value)) {
            throw new InvalidTypeException('Value type is not int.');
        }
    }
}
