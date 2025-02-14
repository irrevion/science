# Quaternion

So, we have finally reached this misterious combination of vectors and complex numbers. As it have been told in [3Blue1brown video](https://www.youtube.com/watch?v=d4EgbgTm0Bg), "Quaternions are an absolutely fascinating and often underuppreciated number system from math".


## Basic usage

```php
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex, ComplexPolar, Vector, QuaternionComponent, Quaternion};

$Q = new Quaternion(new Scalar(-5.75), new Vector([7, 13, 17]));
print "[-5.75 + [7, 13, 17]] -> $Q (".($Q::class).")\n"; // outputs [-5.75 + [7, 13, 17]] -> [-5.75 + 7i + 13j + 17k] (irrevion\science\Math\Entities\Quaternion)

$Q = new Quaternion(new ComplexPolar(26.3, 0.0974));
print "[r 26.3, φ 0.0974] -> $Q (".($Q::class).")\n"; // outputs [r 26.3, φ 0.0974] -> [26.175347698301 + 2.5575716750597i + 0j + 0k] (irrevion\science\Math\Entities\Quaternion)
```


## See also

- [QuaternionComponent](./QuaternionComponent.md)
- [Complex](./Complex.md)
- [Imaginary](./Imaginary.md)
- [Scalar](./Scalar.md)
- [Fraction](./Fraction.md)