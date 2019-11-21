<?php

namespace DA2E\GenericCollection\Type;

class MixedType implements TypeInterface
{
    public function validate($value)
    {
        // mixed type can be any type so pass the validation
    }
}
