# Complex numbers in polar coordinates

Sometimes complex number calculations simplifies significantly when performed in polar coordinates form i.e. expressed as radius (magnitude) and phase angle.

You can swap easily using `Complex::toPolar()` and `ComplexPolar::toRectangular()` methods.

## Basic usage

```php
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Imaginary, Complex, ComplexPolar};

$x = new ComplexPolar(4.27, Math::PI/4);
print("ComplexPolar(4.27, Math::PI/4) to string is {$x}\n"); // outputs ComplexPolar(4.27, Math::PI/4) to string is [4.27, φ 0.25π RAD]
```