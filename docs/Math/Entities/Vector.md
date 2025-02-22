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



## See also

- [Quaternion](./Quaternion.md)
- [QuaternionComponent](./QuaternionComponent.md)
- [ComplexPolar](./ComplexPolar.md)
- [Complex](./Complex.md)
- [Imaginary](./Imaginary.md)
- [Scalar](./Scalar.md)