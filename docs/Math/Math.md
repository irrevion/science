# Math

Math is a static class available under namespace
```php
use irrevion\science\Math\Math;
```
and providing basic methods and constants.

## Constants

```php
const E = M_E;
const E_M = 0.5772156649015; // Euler-Mascheroni Constant
const EPSILON = 1e-13; // PHP_FLOAT_EPSILON is too small
const EULER = M_EULER;
const GOLDEN_RATIO = 1.6180339887499;
const I_POW_I = 0.2078795763507; // i**i
const LN2 = M_LN2;
const LNPI = M_LNPI;
const LN10 = M_LN10;
const LOG2E = M_LOG2E;
const LOG10E = M_LOG10E;
const PI = M_PI;
const SQRT1_2 = M_SQRT1_2;
const SQRT2 = M_SQRT2;
const TAU = 6.2831853071795; // 2 * π = L / R
```
Usage example:
```php
$e = new Scalar(Math::E);
$i = new Imaginary(1);
$π = new Scalar(Math::PI);
$zero = Math::pow($e, $i->multiply($π))->add(1); // [0 + 1.2246467991474E-16i]
$is_zero = $zero->isNear(Delegator::wrap(0, $zero::class));
$is_zero = Math::compare($zero, '=', 0);
```