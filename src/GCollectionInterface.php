<?php

namespace DA2E\GenericCollection;

interface GCollectionInterface extends \IteratorAggregate, \ArrayAccess, \Countable
{
    public function elementsShouldBeTypeOf(string $typeFQN);

    public function toArray(): array;

    public function first();

    public function last();

    public function key();

    public function next();

    public function current();

    public function count(): int;

    public function clear(): void;

    public function containsKey($key): bool;

    public function contains($item): bool;

    public function shuffle(): GCollectionInterface;

    public function slice(int $offset, ?int $length, bool $preserveKeys = false): GCollectionInterface;

    public function map(\Closure $func): GCollectionInterface;

    public function filter(\Closure $p): GCollectionInterface;

    public function resetKeys(): GCollectionInterface;
}
