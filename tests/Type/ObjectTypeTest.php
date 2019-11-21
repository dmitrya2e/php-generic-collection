<?php

namespace DA2E\GenericCollection\Test\Type;

use DA2E\GenericCollection\Test\TypeDataProviderTrait;
use DA2E\GenericCollection\Type\ObjectType;
use DA2E\GenericCollection\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

class ObjectTypeTest extends TestCase
{
    use TypeDataProviderTrait;

    /** @var TypeInterface */
    private $type;

    protected function setUp()
    {
        parent::setUp();

        $this->type = new ObjectType();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidate_WithFQN()
    {
        $obj = new \stdClass();
        $type = new ObjectType('\stdClass');
        $type->validate($obj);
    }

    /**
     * @dataProvider objectDataProvider
     *
     * @doesNotPerformAssertions
     */
    public function testValidate($value)
    {
        $this->type->validate($value);
    }

    /**
     * @dataProvider arrayDataProvider
     * @dataProvider callableDataProvider
     * @dataProvider resourceDataProvider
     * @dataProvider nullDataProvider
     * @dataProvider scalarDataProvider
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
