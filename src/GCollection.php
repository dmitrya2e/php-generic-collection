<?php

namespace DA2E\GenericCollection;

use DA2E\GenericCollection\Exception\InvalidTypeException;
use DA2E\GenericCollection\Type\ObjectType;
use DA2E\GenericCollection\Type\TypeInterface;

/**
 * Generic Collection class. The wrapper for heterogeneous elements.
 *
 * Many methods were taken from doctrine/collections package (map, filter, ...).
 *
 * @see https://github.com/doctrine/collections
 */
class GCollection implements GCollectionInterface
{
    private $type;
    private $items = [];

    public function __construct(TypeInterface $type, array $items = [])
    {
        $this->type = $type;

        foreach ($items as $item) {
            $this->type->validate($item);
        }

        $this->items = $items;
    }

    public function __toString(): string
    {
        return self::class . '@' . spl_object_hash($this);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function first()
    {
        return reset($this->items);
    }

    public function last()
    {
        return end($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function next()
    {
        return next($this->items);
    }

    public function current()
    {
        return current($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function containsKey($key): bool
    {
        return isset($this->items[$key]) || array_key_exists($key, $this->items);
    }

    public function contains($item): bool
    {
        return in_array($item, $this->items, true);
    }

    public function shuffle(): GCollectionInterface
    {
        shuffle($this->items);

        return $this;
    }

    public function slice(int $offset, ?int $length, bool $preserveKeys = false): GCollectionInterface
    {
        $this->items = array_slice($this->items, $offset, $length, $preserveKeys);

        return $this;
    }

    public function map(\Closure $func, ?TypeInterface $newType = null): GCollectionInterface
    {
        $newType = $newType ?? $this->type;
        $newItems = array_map($func, $this->items);

        foreach ($newItems as $newItem) {
            $newType->validate($newItem);
        }

        $this->type = $newType;
        $this->items = $newItems;

        return $this;
    }

    public function filter(\Closure $p): GCollectionInterface
    {
        $this->items = array_filter($this->items, $p, ARRAY_FILTER_USE_BOTH);

        return $this;
    }

    public function resetKeys(): GCollectionInterface
    {
        $this->items = array_values($this->items);

        return $this;
    }

    public function sort(string $sortFunctionName, int $sortFlags = SORT_REGULAR): GCollectionInterface
    {
        $availableFunctions = ['asort', 'arsort', 'krsort', 'ksort', 'rsort', 'sort'];

        if (!in_array($sortFunctionName, $availableFunctions, true)) {
            throw new \InvalidArgumentException();
        }

        $sortFunctionName($this->items, $sortFlags);

        return $this;
    }

    public function natSort(string $sortFunctionName): GCollectionInterface
    {
        $availableFunctions = ['natcasesort', 'natsort'];

        if (!in_array($sortFunctionName, $availableFunctions, true)) {
            throw new \InvalidArgumentException();
        }

        $sortFunctionName($this->items);

        return $this;
    }

    public function userSort(string $sortFunctionName, \Closure $closure): GCollectionInterface
    {
        $availableFunctions = ['uasort', 'uksort', 'usort'];

        if (!in_array($sortFunctionName, $availableFunctions, true)) {
            throw new \InvalidArgumentException();
        }

        $sortFunctionName($this->items, $closure);

        return $this;
    }

    /**
     * @param string $typeFQN
     *
     * @throws InvalidTypeException
     *
     * @return self
     */
    public function elementsShouldBeTypeOf(string $typeFQN): GCollectionInterface
    {
        if (!($this->type instanceof $typeFQN)) {
            if (!($this->type instanceof ObjectType) || $this->type->getFqn() !== $typeFQN) {
                // @TODO: this looks like a hack just to be able to pass a concrete object FQN instead of ObjectType.
                throw new InvalidTypeException();
            }
        }

        return $this;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->items[$offset]) ? $this->items[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $item
     *
     * @throws InvalidTypeException
     */
    public function offsetSet($offset, $item): void
    {
        $this->type->validate($item);

        if ($offset !== null) {
            $this->items[$offset] = $item;
        } else {
            $this->items[] = $item;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }
}
