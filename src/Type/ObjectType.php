<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class ObjectType implements TypeInterface
{
    private $fqn;

    public function __construct(string $fqn = null)
    {
        $this->fqn = $fqn;
    }

    public function validate($value)
    {
        if (!is_object($value) || is_callable($value)) {
            throw new InvalidTypeException('Value type is not object.');
        }

        if ($this->fqn !== null && !($value instanceof $this->fqn)) {
            throw new InvalidTypeException(sprintf(
                'Object %s is not an implementation of %s class.', get_class($value), $this->fqn
            ));
        }
    }

    public function getFqn(): ?string
    {
        return $this->fqn;
    }
}
