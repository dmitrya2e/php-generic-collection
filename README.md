# Generic collection

This small library provides PHP-based implementation for generic collection.

PHP lacks generics (in opposite to Java, C++, etc). The problem is that you can't control and be sure which types do elements implement in an array/collection/hash/...

An example:

```php
$a = [1, 2, new \stdClass(), function () { return 'foo'; }];
$r = 0;

foreach ($a as $v) {
    $r += $v; // here for stdClass and a closure you will get an error: Object of class ... could not be converted to int.
}
```

In Java for example you can eliminate that by using the generics:

```java
List<String> v = new ArrayList<String>();
```

This library provides an OOP solution to have homogeneous types in a collection/array.

## Built-in types

* DA2E\GenericCollection\Type\ArrayType (corresponds to PHP built-in is_array() function).
* DA2E\GenericCollection\Type\BoolType (corresponds to PHP built-in is_bool() function).
* DA2E\GenericCollection\Type\CallableType (corresponds to PHP built-in is_callable() function).
* DA2E\GenericCollection\Type\FloatType (corresponds to PHP built-in is_float() function).
* DA2E\GenericCollection\Type\IntType (corresponds to PHP built-in is_int() function).
* DA2E\GenericCollection\Type\IterableType (corresponds to PHP built-in is_iterable() function).
* DA2E\GenericCollection\Type\MixedType (passes any value through).
* DA2E\GenericCollection\Type\NullType (corresponds to PHP built-in is_null() function).
* DA2E\GenericCollection\Type\NumericType (corresponds to PHP built-in is_numeric() function).
* DA2E\GenericCollection\Type\ObjectType (corresponds to PHP built-in is_object() function).
* DA2E\GenericCollection\Type\ResourceType (corresponds to PHP built-in is_resource() function).
* DA2E\GenericCollection\Type\ScalarType (corresponds to PHP built-in is_scalar() function).
* DA2E\GenericCollection\Type\StringType (corresponds to PHP built-in is_string() function).

Special types:

* DA2E\GenericCollection\Type\CustomType: accepts a callback function with one argument to build a custom validator. E.g.:

```php
use DA2E\GenericCollection\GCollection;
use DA2E\GenericCollection\Type\CustomType;

$collection = new GCollection(new CustomType(function ($value) {
    return $value === 'foobar';
}));

$collection[] = 'foobar'; // valid
$collection[] = 'bar'; // invalid
```

* DA2E\GenericCollection\Type\GCollectionType: a type for embedded GCollections. E.g.:

```php

use DA2E\GenericCollection\Type\GCollectionType;
use DA2E\GenericCollection\Type\StringType;
use DA2E\GenericCollection\GCollection;

$collection = new GCollection(new GCollectionType());
$collection[] = new GCollection(new StringType()); // valid
$collection[] = new StringType(); // invalid
```

### ObjectType

ObjectType optionally accepts a fully-qualified class name to validate that value implements the given class. e.g.:

```php
$value = new Some\Class\Here();
$type = new DA2E\GenericCollection\Type\ObjectType('Some\Class\Here');
$type->validate($value);
```

## How to use

1. Create a Generic Collection.
2. Pass a Type for that collection in a constructor.
3. Generic Collection implements \ArrayAccess interface, so just set/push elements to array.
4. While adding elements to the collection it is immediately validated for the given type.
5. If the type is invalid, a DA2E\GenericCollection\Exception\InvalidTypeException will be thrown.

An example:

```php
use DA2E\GenericCollection\GCollection;
use DA2E\GenericCollection\Type\StringType;
use DA2E\GenericCollection\Exception\InvalidTypeException;

try {
    $collection = new GCollection(new StringType()); // You can pass an array as 2nd argument as well.
    $collection[] = 'string'; // this one is fine
    $collection[] = 1; // this one will throw an exception
} catch (InvalidTypeException $e) {
    // handle exception
}
```

6. If you pass the collection to a method/function as an argument, you could demand that all elements should implement an exact type:

```php
function foobar(GCollection $collection) {
    try {
        $collection->elementsShouldBeTypeOf(StringType::class); // If something is wrong InvalidTypeException is thrown
    } catch (InvalidTypeException $e) {
        // handle exception
    }
    
    // ...
}
```

## Additional functions of GCollectionInterface

There many additional functions in GCollectionInterface (e.g. map, filter, slice, shuffle, etc.). Please refer to the interface to see all of the functions.

### map

```php
use DA2E\GenericCollection\GCollection;
use DA2E\GenericCollection\Type\StringType;

$collection = new GCollection(new StringType(), ['a' ,'b']);
$collection->map(function ($item) {
    return $item . '2';
}); // Returns [ 'a2', 'b2', 'c2' ]
```

### filter

```php
use DA2E\GenericCollection\GCollection;
use DA2E\GenericCollection\Type\StringType;

$collection = new GCollection(new StringType(), ['a' ,'b']);
$collection->filter(function ($item) {
    return $item === 'b';
}); // Returns [ 'b' ]
```

### sort

```php
use DA2E\GenericCollection\GCollection;
use DA2E\GenericCollection\Type\StringType;

$collection = new GCollection(new StringType(), ['a' ,'b']);
$collection->sort(function (array $items) {
    rsort($items); // Here you can call any sort function you wish.

    return $items;
}); // Returns [ 'b', 'a' ]
```
