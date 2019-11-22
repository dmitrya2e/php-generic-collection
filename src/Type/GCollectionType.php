<?php

namespace DA2E\GenericCollection\Type;

use DA2E\GenericCollection\GCollection;

class GCollectionType extends ObjectType
{
    public function __construct()
    {
        parent::__construct(GCollection::class);
    }
}
