<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class NullType implements TypeInterface
{
    public function validate($value)
    {
        if (!is_null($value)) {
            throw new InvalidTypeException('Value type is not null.');
        }
    }
}
