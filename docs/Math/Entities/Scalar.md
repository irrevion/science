# Scalar entity

Most basic and simple entity is Scalar class (object constructor). It is a wrapper for real numbers.
Namespace and dependencies:
```php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Delegator;

class Scalar implements Entity {}
```


## Quick overview / Basic usage

```php
use irrevion\science\Math\Entities\{NaN, Scalar};

$x = new Scalar(5);
$y = new Scalar(3);
$z = $x->multiply($y);
```

Constuctor accepts only one parameter. It can be either instance of Scalar entity, or numeric type (integer, float, numeric string). Otherwise TypeError `"Invalid argument type ( ".($x::class)." )"` will be thrown.
Following statements are equivalent:
```php
$n = new Scalar(-1.67e-117);
$n = new Scalar("-1.67e-117");
$n = new Scalar(new Scalar("-1.67e-117"));
```
Other entities should be firstly converted to a number to become Scalar entity:
```php
use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Entities\{Scalar, Fraction};

$ar = new Fraction('16/9');
$n = new Scalar($ar->toNumber()); // or
$n = Delegator::wrap($ar->toNumber()); // or
$n = (new Scalar(1))->multiply($ar);
```
Take a note that when Scalar multiplied Fraction result is Scalar, but when Fraction is multiplied Scalar result is Fraction.

## Class synopsis

```php
class Scalar implements Entity {
	public function __construct($x = 0) {}
	public function __toString() {}
	public function toNumber() {}
	public function isScalar() {}
	public function isNaN(): bool {}
	public function isEqual($y): bool {}
	public function isNear($y): bool {}
	public function empty(): bool {}
	public function add($x) {}
	public function subtract($x) {}
	public function multiply($x) {}
	public function divide($x) {}
	public function abs() {}
	public function invert() {}
	public function negative() {} // alias for Scalar::invert()
	public function reciprocal() {}
}
```
Didn't found pow() method? Use [Math::pow()](../../Math.md) like this:
```php
$x = new Scalar(125);
$y = new Fraction('2/3');
$z = Math::pow($x, $y);
```


## See also

- [NaN](./NaN.md)
- [Fraction](./Fraction.md)
- [Complex](./Complex.md)