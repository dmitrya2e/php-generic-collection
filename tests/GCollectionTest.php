<?php

namespace DA2E\GenericCollection\Test;

use DA2E\GenericCollection\GCollection;
use DA2E\GenericCollection\GCollectionInterface;
use DA2E\GenericCollection\Type\MixedType;
use DA2E\GenericCollection\Type\StringType;
use PHPUnit\Framework\TestCase;

class GCollectionTest extends TestCase
{
    public function test_ImplementsInterfaces()
    {
        $c = new GCollection(new MixedType());

        $this->assertInstanceOf(GCollectionInterface::class, $c);
        $this->assertInstanceOf(\IteratorAggregate::class, $c);
        $this->assertInstanceOf(\ArrayAccess::class, $c);
    }

    public function test_IteratorAggregate()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = 2;

        $this->assertTrue(is_iterable($c));
        $this->assertCount(2, $c);
    }

    public function test_ArrayAccess()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = 2;

        $this->assertCount(2, $c);
        $this->assertArrayHasKey(0, $c);
        $this->assertArrayHasKey(1, $c);

        $this->assertSame(1, $c[0]);
        $this->assertSame(2, $c[1]);

        unset($c[0]);

        $this->assertCount(1, $c);
        $this->assertSame(2, $c[1]);
    }

    /**
     * @expectedException \DA2E\GenericCollection\Exception\InvalidTypeException
     */
    public function test_PushElementWithWrongType()
    {
        $c = new GCollection(new StringType());
        $c[] = 'correct element';
        $c[] = 1;
    }

    /**
     * @expectedException \DA2E\GenericCollection\Exception\InvalidTypeException
     */
    public function test_SetElementWithWrongType()
    {
        $c = new GCollection(new StringType());
        $c[] = 'correct element';
        $c['foo'] = 1;
    }

    /**
     * @expectedException \DA2E\GenericCollection\Exception\InvalidTypeException
     */
    public function testElementShouldBeTypeOf()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = '1';

        $c->elementsShouldBeTypeOf(StringType::class);
    }
}
