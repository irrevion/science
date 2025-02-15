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

## Constructor

You can create an instance of a Quaternion in different ways. Some of them was already shown above:
```php
$Q = new Quaternion(new Scalar(-5.75), new Vector([7, 13, 17]));
$Q = new Quaternion(new ComplexPolar(26.3, 0.0974));
```

You can also create a copy of another Quaternion:
```php
$q1 = new Quaternion(new Scalar(1), new Vector([2, 3, 4]));
$q2 = new Quaternion($q1);
```

## Addition / Subtraction

There are methods for addition and subtraction of quaternions:
```php
$q1 = new Quaternion(new Scalar(1), new Vector([2, 3, 4]));
$q2 = new Quaternion(new Scalar(5), new Vector([6, 7, 8]));

$sum = $q1->add($q2); // result is [6 + 8i + 10j + 12k]
$diff = $q1->subtract($q2); // result is [-4 - 4i - 4j - 4k]
```

## Multiplication / Division

Quaternion multiplication and division methods are also available:
```php
$prod = $q1->multiply($q2); // result is [-60 + 12i + 30j + 24k]
$quotient = $q1->divide($q2); // result is [0.033333333333333 + 0.066666666666667i + 0.1j + 0.13333333333333k]
```

## Other methods

Conjugate:
```php
$conjugate = $q1->conjugate(); // result is [1 - 2i - 3j - 4k]
```

Magnitude:
```php
$magnitude = $q1->abs(); // result is 5.4772255750517
```

Inverse:
```php
$inverse = $q1->inverse(); // result is [0.033333333333333 - 0.066666666666667i - 0.1j - 0.13333333333333k]
```


## See also

- [QuaternionComponent](./QuaternionComponent.md)
- [Complex](./Complex.md)
- [Imaginary](./Imaginary.md)
- [Scalar](./Scalar.md)
- [Fraction](./Fraction.md)