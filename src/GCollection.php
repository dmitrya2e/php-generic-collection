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

        return new self($this->type, $this->items);
    }

    public function slice(int $offset, ?int $length, bool $preserveKeys = false): GCollectionInterface
    {
        return new self($this->type, array_slice($this->items, $offset, $length, $preserveKeys));
    }

    public function map(\Closure $func): GCollectionInterface
    {
        return new self($this->type, array_map($func, $this->items));
    }

    public function filter(\Closure $p): GCollectionInterface
    {
        return new self($this->type, array_filter($this->items, $p, ARRAY_FILTER_USE_BOTH));
    }

    public function resetKeys(): GCollectionInterface
    {
        $this->items = array_values($this->items);

        return $this;
    }

    public function sort(\Closure $p): GCollectionInterface
    {
        $this->items = $p($this->items);

        return $this;
    }

    /**
     * @param string $typeFQN
     *
     * @throws InvalidTypeException
     */
    public function elementsShouldBeTypeOf(string $typeFQN)
    {
        if (!($this->type instanceof $typeFQN)) {
            if (!($this->type instanceof ObjectType) || !$this->type->getFqn()) {
                // @TODO: this looks like a hack just to be able to pass a concrete object FQN instead of ObjectType.
                throw new InvalidTypeException();
            }

            foreach ($this->items as $item) {
                $this->type->validate($item);
            }
        }
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
