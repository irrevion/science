# Vector

Vector class provides constructor to instantiate arbitrary vector and incapsulates common linear algebra methods to interact with it.

It implements `irrevion\science\Math\Entities\Entity`, `\Iterator`, `\ArrayAccess`, `\Countable` interfaces as it can be seen by its definition:
```php
<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Delegator;

class Vector extends Scalar implements Entity, \Iterator, \ArrayAccess, \Countable {}
```

Yep, it extends Scalar, because thats what the single-dimensional vector looks like, just good old arrow on the real number line and any n-dimensional vector behave just like number for any other collinear vector.


## Basic usage

```php
use irrevion\science\Math\Entities\{Scalar, Vector};

$x = new Vector([2, 3, 5]);
```


## Constructor

Here is Vector class constructor's signature:
```php
public function __construct($array=[], $type=self::T_SCALAR, $pad_to_length=0) {}
```
So, you can pass in array of values and values will be mapped as objects of type denoted by second parameter. You can also pad it with zero values using third parameter.

If instead of array an Entity is passed, constructor will try to transform it to array using `$array->toArray()` method. Otherwise if Entity have no such method, it will be treated as only element of array.


## Addition / Subtraction

There are methods for addition and subtraction of vectors:
```php
$v1 = new Vector([1, 2, 3]);
$v2 = new Vector([4, 5, 6]);

$sum = $v1->add($v2); // result is [5, 7, 9]
$diff = $v1->subtract($v2); // result is [-3, -3, -3]
```

## Multiplication / Division

Vector multiplication and division methods are also available:
```php
$prod = $v1->multiply($v2); // element-wise multiplication, result is [4, 10, 18]
$quotient = $v1->divide($v2); // element-wise division, result is [0.25, 0.4, 0.5]
```

## Dot Product

You can calculate the dot product of two vectors:
```php
$dotProduct = $v1->dot($v2); // result is 32
```

## Cross Product

You can calculate the cross product of two vectors (only for 3-dimensional vectors):
```php
$v1 = new Vector([1, 2, 3]);
$v2 = new Vector([4, 5, 6]);

$crossProduct = $v1->cross($v2); // result is [-3, 6, -3]
```

## Magnitude

You can calculate the magnitude (length) of a vector:
```php
$magnitude = $v1->abs(); // result is 3.7416573867739
```

## Normalization

You can normalize a vector (make it a unit vector):
```php
$normalized = $v1->normalize(); // result is [0.26726124191242, 0.53452248382485, 0.80178372573727]
```

## Cosine and Angle Between Vectors

You can calculate the cosine of the angle between two vectors and the angle itself:

```php
// Cosine of the angle between $v1 and $v2
$cosine = $v1->cos($v2); // result is a scalar value between -1 and 1

// Angle (in radians) between $v1 and $v2
$angle = $v1->angle($v2); // result is the angle in radians
```

- `cos($other)` returns the cosine of the angle between the current vector and `$other`.
- `angle($other)` returns the angle (in radians) between the current vector and `$other`. You can convert radians to degrees using `Math::rad2deg($angle)` method.

## Projection

You can project one vector onto another using the `projTo()` and `proj()` methods:

```php
// Project $v1 onto $v2
$projection = $v1->projTo($v2); // result is the projection vector of $v1 onto $v2

// Project $v1 onto $v2
$projection2 = $v2->proj($v1); // result is the projection vector of $v1 onto $v2
```

- `projTo($other)` projects the current vector onto `$other`.
- `proj($other)` projects `$other` onto the current vector.


## See also

- [Quaternion](./Quaternion.md)
- [QuaternionComponent](./QuaternionComponent.md)
- [ComplexPolar](./ComplexPolar.md)
- [Complex](./Complex.md)
- [Imaginary](./Imaginary.md)
- [Scalar](./Scalar.md)