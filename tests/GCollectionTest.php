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

        $this->assertSame(['b', 'c'], $c->slice(1, 2)->toArray());
        $this->assertSame([1 => 'c'], $c->slice(1, 1, true)->toArray());
    }

    public function testMap()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $c->map(function ($item) {
            return $item . '2';
        });

        $this->assertSame(['a2', 'b2', 'c2'], $c->toArray());
    }

    public function testFilter()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $c->filter(function ($item) {
            return $item === 'b';
        });

        $this->assertSame([1 => 'b'], $c->toArray());
    }

    public function testResetKeys()
    {
        $c = new GCollection(new MixedType());
        $c[] = 'a';
        $c[] = 'b';
        $c[] = 'c';

        $this->assertSame(['b'], $c->slice(1, 1)->resetKeys()->toArray());
    }

    public function dataProvider_SortFunctions()
    {
        return [
            ['asort'], ['arsort'], ['krsort'], ['ksort'], ['rsort'], ['sort'],
        ];
    }

    /**
     * @dataProvider dataProvider_SortFunctions
     */
    public function testSort(string $sortFunction)
    {
        $c = new GCollection(new MixedType());
        $c[] = 3;
        $c[] = 2;
        $c[] = 1;

        $c->sort($sortFunction);

        $this->assertTrue(true);
    }

    public function testSort_Sort()
    {
        $c = new GCollection(new MixedType());
        $c[] = 3;
        $c[] = 2;
        $c[] = 1;

        $c->sort('sort');

        $this->assertSame([1, 2, 3], $c->resetKeys()->toArray());
    }

    public function dataProvider_NatSortFunctions()
    {
        return [
            ['natsort'], ['natcasesort'],
        ];
    }

    /**
     * @dataProvider dataProvider_NatSortFunctions
     */
    public function testNatSort(string $sortFunction)
    {
        $c = new GCollection(new MixedType());
        $c[] = 3;
        $c[] = 2;
        $c[] = 1;

        $c->natSort($sortFunction);

        $this->assertTrue(true);
    }

    public function testNatSort_NatSort()
    {
        $c = new GCollection(new MixedType());
        $c[] = 3;
        $c[] = 2;
        $c[] = 1;

        $c->natSort('natsort');

        $this->assertSame([1, 2, 3], $c->resetKeys()->toArray());
    }

    public function dataProvider_UserSortFunctions()
    {
        return [
            ['usort'], ['uasort'], ['uksort'],
        ];
    }

    /**
     * @dataProvider dataProvider_UserSortFunctions
     */
    public function testUserSort(string $sortFunction)
    {
        $c = new GCollection(new MixedType());
        $c[] = 3;
        $c[] = 2;
        $c[] = 1;

        $c->userSort($sortFunction, function ($a, $b) {
            return 0;
        });

        $this->assertTrue(true);
    }

    public function testUserSort_Usort()
    {
        $c = new GCollection(new MixedType());
        $c[] = 3;
        $c[] = 2;
        $c[] = 1;

        $c->userSort('usort', function ($a, $b) {
            return $a > $b;
        });

        $this->assertSame([1, 2, 3], $c->resetKeys()->toArray());
    }
}
