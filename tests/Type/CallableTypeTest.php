<?php

namespace DA2E\GenericCollection\Test\Type;

use DA2E\GenericCollection\Test\TypeDataProviderTrait;
use DA2E\GenericCollection\Type\CallableType;
use DA2E\GenericCollection\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

class CallableTypeTest extends TestCase
{
    use TypeDataProviderTrait;

    /** @var TypeInterface */
    private $type;

    protected function setUp()
    {
        parent::setUp();

        $this->type = new CallableType();
    }

    /**
     * @dataProvider callableDataProvider
     *
     * @doesNotPerformAssertions
     */
    public function testValidate(callable $callable)
    {
        $this->type->validate($callable);
    }

    /**
     * @dataProvider objectDataProvider
     * @dataProvider arrayDataProvider
     * @dataProvider boolDataProvider
     * @dataProvider resourceDataProvider
     * @dataProvider nullDataProvider
     * @dataProvider intDataProvider
     * @dataProvider floatDataProvider
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
