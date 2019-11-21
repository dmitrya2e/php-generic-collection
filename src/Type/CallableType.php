<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class CallableType implements TypeInterface
{
    public function validate($value)
    {
        if (!is_callable($value)) {
            throw new InvalidTypeException('Value type is not callable.');
        }
    }
}
