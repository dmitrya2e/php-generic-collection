<?php

namespace DA2E\GenericCollection;

use DA2E\GenericCollection\Type\TypeInterface;

interface GCollectionInterface extends \IteratorAggregate, \ArrayAccess, \Countable
{
    public function elementsShouldBeTypeOf(string $typeFQN): GCollectionInterface;

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
     * Shuffles items and returns the same collection.
     *
     * @return GCollectionInterface
     */
    public function shuffle(): GCollectionInterface;

    /**
     * Slices items and returns the same collection.
     *
     * @return GCollectionInterface
     */
    public function slice(int $offset, ?int $length, bool $preserveKeys = false): GCollectionInterface;

    /**
     * Maps items and returns the same collection.
     *
     * @param \Closure           $func    Should accept single argument - the item. Should return mapped item.
     * @param null|TypeInterface $newType New type after mapping (leave empty if type is not changing)
     *
     * @return GCollectionInterface
     */
    public function map(\Closure $func, ?TypeInterface $newType = null): GCollectionInterface;

    /**
     * Filters items and returns the same collection.
     *
     * @param \Closure $p Should accept single argument - the item. Should return bool.
     *
     * @return GCollectionInterface
     */
    public function filter(\Closure $p): GCollectionInterface;

    /**
     * Resets keys of items and returns the same collection.
     *
     * @return GCollectionInterface
     */
    public function resetKeys(): GCollectionInterface;

    /**
     * Performs sorting and returns the same collection.
     *
     * @param string $sortFunctionName asort|arsort|ksort|krsort|rsort|sort
     * @param int    $sortFlags        SORT_REGULAR|SORT_NUMERIC|SORT_STRING|SORT_LOCALE_STRING|SORT_NATURAL|SORT_FLAG_CASE
     *
     * @return GCollectionInterface
     */
    public function sort(string $sortFunctionName, int $sortFlags = SORT_REGULAR): GCollectionInterface;

    /**
     * Performs natural sorting and returns the same collection.
     *
     * @param string $sortFunctionName natcasesort|natsort
     *
     * @return GCollectionInterface
     */
    public function natSort(string $sortFunctionName): GCollectionInterface;

    /**
     * Performs user sorting and returns the same collection.
     *
     * @param string   $sortFunctionName uasort|uksort|usort
     * @param \Closure $closure          CMP function to sort
     *
     * @return GCollectionInterface
     */
    public function userSort(string $sortFunctionName, \Closure $closure): GCollectionInterface;
}
