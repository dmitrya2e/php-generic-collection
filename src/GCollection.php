<?php

namespace DA2E\GenericCollection;

use DA2E\GenericCollection\Exception\InvalidTypeException;
use DA2E\GenericCollection\Type\TypeInterface;

class GCollection implements GCollectionInterface
{
    private $type;
    private $items = [];

    public function __construct(TypeInterface $type)
    {
        $this->type = $type;
    }

    /**
     * @param string $typeFQN
     *
     * @throws InvalidTypeException
     */
    public function elementsShouldBeTypeOf(string $typeFQN)
    {
        if (get_class($this->type) !== $typeFQN) {
            throw new InvalidTypeException();
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
