<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class StringType extends ScalarType
{
    public function validate($value)
    {
        if (!is_string($value)) {
            throw new InvalidTypeException('Value type is not string.');
        }
    }
}
