<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class FloatType extends NumericType
{
    public function validate($value)
    {
        if (!is_float($value)) {
            throw new InvalidTypeException('Value type is not float.');
        }
    }
}
