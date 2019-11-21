<?php

namespace DA2E\GenericCollection\Test\Type;

use DA2E\GenericCollection\Test\TypeDataProviderTrait;
use DA2E\GenericCollection\Type\IterableType;
use DA2E\GenericCollection\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

class IterableTypeTest extends TestCase
{
    use TypeDataProviderTrait;

    /** @var TypeInterface */
    private $type;

    protected function setUp()
    {
        parent::setUp();

        $this->type = new IterableType();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidate()
    {
        $this->type->validate([]);
    }

    /**
     * @dataProvider objectDataProvider
     * @dataProvider callableDataProvider
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
