<?php

namespace DA2E\GenericCollection;

interface GCollectionInterface extends \IteratorAggregate, \ArrayAccess
{
    public function elementsShouldBeTypeOf(string $typeFQN);
}
