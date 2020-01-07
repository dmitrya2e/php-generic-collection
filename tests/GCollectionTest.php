<?php

namespace DA2E\GenericCollection\Test;

use DA2E\GenericCollection\GCollection;
use DA2E\GenericCollection\GCollectionInterface;
use DA2E\GenericCollection\Type\MixedType;
use DA2E\GenericCollection\Type\ObjectType;
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

    public function testElementShouldBeTypeOf_CheckConcreteObjectFQN()
    {
        $c = new GCollection(new ObjectType(\stdClass::class));
        $c[] = new \stdClass();
        $c[] = new \stdClass();

        $c->elementsShouldBeTypeOf(\stdClass::class);

        $this->assertTrue(true);
    }

    public function testToArray()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;

        $array = $c->toArray();

        $this->assertTrue(is_array($array));
        $this->assertCount(1, $array);
        $this->assertSame(1, reset($array));
    }

    public function testFirst()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = 2;
        $c[] = 3;

        $this->assertSame(1, $c->first());
    }

    public function testLast()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = 2;
        $c[] = 3;

        $this->assertSame(3, $c->last());
    }

    public function testKey()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = 2;
        $c[] = 3;

        $c->next();

        $this->assertSame(1, $c->key());
    }

    public function testNext()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = 2;
        $c[] = 3;

        $c->next();

        $this->assertSame(2, $c->current());
    }

    public function testCurrent()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = 2;
        $c[] = 3;

        $c->next();
        $c->next();

        $this->assertSame(3, $c->current());
    }

    public function testCount()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = 2;
        $c[] = 3;

        $this->assertSame(3, $c->count());
    }

    public function testClear()
    {
        $c = new GCollection(new MixedType());
        $c[] = 1;
        $c[] = 2;
        $c[] = 3;

        $c->clear();

        $this->assertSame(0, $c->count());
    }

    public function testContainsKey()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $this->assertTrue($c->containsKey(1));
        $this->assertFalse($c->containsKey(999));
    }

    public function testContains()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $this->assertTrue($c->contains('c'));
        $this->assertFalse($c->contains('d'));
    }

    public function testShuffle()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $maxShuffleAttempts = 10;
        $i = 0;

        do {
            $i++;
            $c->shuffle();
            $differs = $c->toArray() !== ['a', 'b', 'c'];

            if ($i === $maxShuffleAttempts) {
                $this->fail(sprintf(
                    'After %d attempts could not get shuffled collection.', $maxShuffleAttempts
                ));

                return;
            }
        } while ($differs == false);

        $this->assertTrue($differs);;
    }

    public function testSlice()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $this->assertSame(['b'], $c->slice(1, 1)->toArray());
        $this->assertSame([1 => 'b'], $c->slice(1, 1, true)->toArray());
    }

    public function testMap()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $c2 = $c->map(function ($item) {
            return $item . '2';
        });

        $this->assertSame(['a2', 'b2', 'c2'], $c2->toArray());
    }

    public function testFilter()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $c2 = $c->filter(function ($item) {
            return $item === 'b';
        });

        $this->assertSame([1 => 'b'], $c2->toArray());
    }

    public function testResetKeys()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $this->assertSame(['b'], $c->slice(1, 1)->resetKeys()->toArray());
    }

    public function testSort()
    {
        $c = new GCollection(new MixedType());
        $c[] = 3;
        $c[] = 2;
        $c[] = 1;

        $c->sort(function (array $items) {
            usort($items, function ($a, $b) {
                return $a > $b;
            });

            return $items;
        });

        $this->assertSame([1, 2, 3], $c->resetKeys()->toArray());

        $c->sort(function (array $items) {
            sort($items);

            return $items;
        });

        $this->assertSame([1, 2, 3], $c->resetKeys()->toArray());

        $c->sort(function (array $items) {
            krsort($items);

            return $items;
        });

        $this->assertSame([3, 2, 1], $c->resetKeys()->toArray());
    }
}
