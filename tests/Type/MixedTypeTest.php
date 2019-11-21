<?php

namespace DA2E\GenericCollection\Test\Type;

use DA2E\GenericCollection\Test\TypeDataProviderTrait;
use DA2E\GenericCollection\Type\MixedType;
use DA2E\GenericCollection\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

class MixedTypeTest extends TestCase
{
    use TypeDataProviderTrait;

    /** @var TypeInterface */
    private $type;

    protected function setUp()
    {
        parent::setUp();

        $this->type = new MixedType();
    }

    /**
     * @dataProvider objectDataProvider
     * @dataProvider callableDataProvider
     * @dataProvider arrayDataProvider
     * @dataProvider scalarDataProvider
     *
     * @doesNotPerformAssertions
     */
    public function testValidate($value)
    {
        $this->type->validate($value);
    }
}
