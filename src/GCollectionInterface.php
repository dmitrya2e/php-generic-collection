<?php

namespace DA2E\GenericCollection;

interface GCollectionInterface extends \IteratorAggregate, \ArrayAccess, \Countable
{
    public function elementsShouldBeTypeOf(string $typeFQN);

    /**
     * Gets array representation of internal items.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Gets a first item.
     *
     * @return mixed
     */
    public function first();

    /**
     * Gets a last item.
     *
     * @return mixed
     */
    public function last();

    /**
     * Gets a current key.
     *
     * @return mixed
     */
    public function key();

    /**
     * Sets cursor to next item in an array.
     *
     * @return mixed
     */
    public function next();

    /**
     * Gets current item.
     *
     * @return mixed
     */
    public function current();

    /**
     * Counts items.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Removes all items from collection.
     */
    public function clear(): void;

    /**
     * Checks if the key exists in items.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function containsKey($key): bool;

    /**
     * Checks if the item exists.
     *
     * @param mixed $item
     *
     * @return bool
     */
    public function contains($item): bool;

    /**
     * Shuffles items and returns a new collection.
     *
     * @return GCollectionInterface
     */
    public function shuffle(): GCollectionInterface;

    /**
     * Slices items and returns a new collection.
     *
     * @return GCollectionInterface
     */
    public function slice(int $offset, ?int $length, bool $preserveKeys = false): GCollectionInterface;

    /**
     * Maps items and returns a new collection.
     *
     * @param \Closure $func Should accept single argument - the item. Should return mapped item.
     *
     * @return GCollectionInterface
     */
    public function map(\Closure $func): GCollectionInterface;

    /**
     * Filters items and returns a new collection.
     *
     * @param \Closure $p Should accept single argument - the item. Should return bool.
     *
     * @return GCollectionInterface
     */
    public function filter(\Closure $p): GCollectionInterface;

    /**
     * Resets keys of items and returns THE SAME collection.
     *
     * @return GCollectionInterface
     */
    public function resetKeys(): GCollectionInterface;

    /**
     * @param \Closure $p Should accept single argument - an array of items. Should return sorted array.
     *
     * @return GCollectionInterface
     */
    public function sort(\Closure $p): GCollectionInterface;
}
