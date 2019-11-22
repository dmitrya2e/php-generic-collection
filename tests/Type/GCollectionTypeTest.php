<?php

namespace DA2E\GenericCollection\Test\Type;

use DA2E\GenericCollection\GCollection;
use DA2E\GenericCollection\Test\TypeDataProviderTrait;
use DA2E\GenericCollection\Type\GCollectionType;
use DA2E\GenericCollection\Type\StringType;
use DA2E\GenericCollection\Type\TypeInterface;
use PHPUnit\Framework\TestCase;

class GCollectionTypeTest extends TestCase
{
    use TypeDataProviderTrait;

    /** @var TypeInterface */
    private $type;

    protected function setUp()
    {
        parent::setUp();

        $this->type = new GCollectionType();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testValidate()
    {
        $this->type->validate(new GCollection(new StringType()));
    }

    /**
     * @expectedException \DA2E\GenericCollection\Exception\InvalidTypeException
     */
    public function testValidate_InvalidType()
    {
        $this->type->validate('foobar');
    }
}
