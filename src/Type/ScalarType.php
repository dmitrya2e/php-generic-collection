<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class ScalarType implements TypeInterface
{
    public function validate($value)
    {
        if (!is_scalar($value)) {
            throw new InvalidTypeException('Value type is not scalar.');
        }
    }
}
