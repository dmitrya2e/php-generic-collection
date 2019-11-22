<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\Exception\InvalidTypeException;

class CustomType implements TypeInterface
{
    private $validationFunction;

    public function __construct(callable $validationFunction)
    {
        $this->validationFunction = $validationFunction;
    }

    public function validate($value)
    {
        $isValid = call_user_func($this->validationFunction, $value);

        if ($isValid === false) {
            throw new InvalidTypeException();
        }
    }
}
