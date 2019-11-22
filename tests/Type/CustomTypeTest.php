<?php

namespace DA2E\GenericCollection\Test\Type;

use DA2E\GenericCollection\Test\TypeDataProviderTrait;
use DA2E\GenericCollection\Type\CustomType;
use PHPUnit\Framework\TestCase;

class CustomTypeTest extends TestCase
{
    use TypeDataProviderTrait;

    /**
     * @doesNotPerformAssertions
     */
    public function testValidate()
    {
        $type = new CustomType(function ($value) {
            return $value === 'foobar';
        });

        $type->validate('foobar');
    }

    /**
     * @expectedException \DA2E\GenericCollection\Exception\InvalidTypeException
     */
    public function testValidate_InvalidType()
    {
        $type = new CustomType(function ($value) {
            return $value === 'foobar';
        });

        $type->validate('bar');
    }
}
