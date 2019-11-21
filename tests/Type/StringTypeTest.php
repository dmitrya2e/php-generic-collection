<?php

namespace DA2E\GenericCollection\Test\Type;

use DA2E\GenericCollection\Test\TypeDataProviderTrait;
use DA2E\GenericCollection\Type\StringType;
use DA2E\GenericCollection\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

class StringTypeTest extends TestCase
{
    use TypeDataProviderTrait;

    /** @var TypeInterface */
    private $type;

    protected function setUp()
    {
        parent::setUp();

        $this->type = new StringType();
    }

    /**
     * @dataProvider stringDataProvider
     *
     * @doesNotPerformAssertions
     */
    public function testValidate(string $value)
    {
        $this->type->validate($value);
    }

    /**
     * @dataProvider objectDataProvider
     * @dataProvider arrayDataProvider
     * @dataProvider callableDataProvider
     * @dataProvider resourceDataProvider
     * @dataProvider nullDataProvider
     * @dataProvider intDataProvider
     * @dataProvider floatDataProvider
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
