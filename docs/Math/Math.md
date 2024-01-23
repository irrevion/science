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

## Quick overview

Methods available:
```php
Math::abs($n);
Math::acos($n);
Math::acosh($n);
Math::asin($n);
Math::asinh($n);
Math::atan($n);
Math::atan2($y, $x);
Math::atanh($n);
Math::avg(...$args);
Math::base_convert($num, $from_base=10, $to_base=16);
Math::bindec($n);
Math::ceil($n);
Math::compare($x=0.0, $rel='==', $y=0.0);
Math::cos($n);
Math::cosh($n);
Math::decbin($n);
Math::dechex($n);
Math::decoct($n);
Math::deg2rad($n);
Math::diagonal($x, $y);
Math::exp($n);
Math::expm1($n);
Math::factorial($n);
Math::fdiv($x, $y);
Math::floor($n);
Math::fmod($x, $y);
Math::gcd($x, $y);
Math::gcd_simplify($x, $y);
Math::hexdec($n);
Math::hypot($x, $y);
Math::intdiv($x, $y);
Math::isFloat($n);
Math::isNaN($n);
Math::isNatural($n);
Math::isNegative($n);
Math::isReal($n);
Math::lcm($x, $y);
Math::ln($n);
Math::log10($n);
Math::log1p($n);
Math::log($num, $base = M_E);
Math::octdec($n);
Math::polar2rectangular($radius, $phase_angle=0);
Math::polar_absolute($radius, $phase_angle=0);
Math::pow($n, $exp);
Math::rad2deg($angle);
Math::rectangular2polar($x, $y);
Math::round($num, $precision=0, $mode=PHP_ROUND_HALF_UP);
Math::sign($n);
Math::sin($n);
Math::sinh($n);
Math::sqrt($n);
Math::sum($arr);
Math::tan($n);
Math::tanh($n);
```