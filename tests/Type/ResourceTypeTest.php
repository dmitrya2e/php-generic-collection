<?php

namespace DA2E\GenericCollection\Test\Type;

use DA2E\GenericCollection\Test\TypeDataProviderTrait;
use DA2E\GenericCollection\Type\ResourceType;
use DA2E\GenericCollection\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

class ResourceTypeTest extends TestCase
{
    use TypeDataProviderTrait;

    /** @var TypeInterface */
    private $type;

    protected function setUp()
    {
        parent::setUp();

        $this->type = new ResourceType();
    }

    /**
     * @dataProvider resourceDataProvider
     *
     * @doesNotPerformAssertions
     */
    public function testValidate($value)
    {
        $this->type->validate($value);
    }

    /**
     * @dataProvider objectDataProvider
     * @dataProvider arrayDataProvider
     * @dataProvider callableDataProvider
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
