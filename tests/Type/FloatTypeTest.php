<?php

namespace DA2E\GenericCollection\Test\Type;

use DA2E\GenericCollection\Test\TypeDataProviderTrait;
use DA2E\GenericCollection\Type\FloatType;
use DA2E\GenericCollection\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

class FloatTypeTest extends TestCase
{
    use TypeDataProviderTrait;

    /** @var TypeInterface */
    private $type;

    protected function setUp()
    {
        parent::setUp();

        $this->type = new FloatType();
    }

    /**
     * @dataProvider floatDataProvider
     *
     * @doesNotPerformAssertions
     */
    public function testValidate(float $value)
    {
        $this->type->validate($value);
    }

    /**
     * @dataProvider objectDataProvider
     * @dataProvider arrayDataProvider
     * @dataProvider boolDataProvider
     * @dataProvider resourceDataProvider
     * @dataProvider nullDataProvider
     * @dataProvider intDataProvider
     * @dataProvider stringDataProvider
     * @dataProvider numericDataProvider
     *
     * @expectedException \DA2E\GenericCollection\Exception\InvalidTypeException
     *
     * @param mixed $value
     */
    public function testValidate_InvalidType($value)
    {
        $this->type->validate($value);
    }
}
