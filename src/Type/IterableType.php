<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class IterableType implements TypeInterface
{
    public function validate($value)
    {
        if (!is_iterable($value)) {
            throw new InvalidTypeException('Value is not iterable.');
        }
    }
}
