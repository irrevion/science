# NaN

The default PHP NaN value is type of float. PHP provides built-in function [is_nan()](https://www.php.net/manual/en/function.is-nan.php) to distinquish this float number apart of valid number.

All functions that should return Entity object (implementing Entity interface) in case when NaN value emerges in calculation wraps it using NaN class:
```php
<?php
namespace irrevion\science\Math\Entities;

class NaN implements Entity {
	public $value = null;
	public function __construct() {}
	public function __toString() {return "NaN";}
	public function toNumber() {return sqrt(-1);}
	public function add($n) {return $this;}
	public function subtract($n) {return $this;}
	public function multiply($n) {return $this;}
	public function divide($n) {return $this;}
	public function isNaN() {return true;}
}
?>
```
So you can avoid getting result as non-Entity number type.

Once imported
```php
use irrevion\science\Math\Entities\{NaN, Scalar};
```
you can use it to return invalid number as object:
```php
return new NaN;
```

## Examples

Lets check out some occasions and use cases. Imagine we have a function returning positive infinity with type float:
```php
use irrevion\science\Math\Math;

$x = Math::factorial(777);
var_dump($x); // outputs float(INF)
print "Math::isNaN() returns ".var_export(Math::isNaN($x), true)." \n"; // outputs Math::isNaN() returns true
```
So, as we can observe, when using `Math::isNaN()` function to determine if this is a valid number, it will return true for infinity value too. In general it will return true in cases when it is NaN class Entity, any other object not implementing Entity interface, NULL, Array, Infinity or (float)NaN.

Here is another example since factorial from a float argument will return NaN value.
```php
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\Scalar;

$x = Math::factorial(new Scalar(8.12));
print "8.12! is {$x} \n"; // outputs 8.12! is NaN
print "Math::isNaN() returns ".var_export(Math::isNaN($x), true)." \n"; // outputs Math::isNaN() returns true
```
In this case NaN Entity instance is returned and `var_dump()` of this value will be something like this:
```
object(irrevion\science\Math\Entities\NaN)#4 (1) {
  ["value"]=> NULL
}
```
Entity interface also declarates isNaN() abstract function to be implemented in Entity subclasses. For example:
```php
use irrevion\science\Math\Entities\{NaN, Scalar};

$x = new NaN;
print "\$x->isNaN($x) returns ".var_export($x->isNaN($x), true)." \n"; // $x->isNaN(NaN) returns true
$x = new Scalar(INF);
print "\$x->isNaN($x) returns ".var_export($x->isNaN($x), true)." \n"; // $x->isNaN(INF) returns true
$x = new Scalar(-0.000000);
print "\$x->isNaN($x) returns ".var_export($x->isNaN($x), true)." \n"; // $x->isNaN(-0) returns false
```
It is took as convention that anything other than finite-value real number will be counted as NaN. So Complex numbers are NaN, Imaginary numbers are NaN, Quaternions, Vectors, Bivectors, Matrices, etc. are also NaN.