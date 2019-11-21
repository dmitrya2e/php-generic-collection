<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class ResourceType implements TypeInterface
{
    public function validate($value)
    {
        if (!is_resource($value)) {
            throw new InvalidTypeException('Value type is not resource.');
        }
    }
}
