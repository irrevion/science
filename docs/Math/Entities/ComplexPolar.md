# Complex numbers in polar coordinates

Sometimes complex number calculations simplifies significantly when performed in polar coordinates form i.e. expressed as radius (magnitude) and phase angle.

You can swap easily using `Complex::toPolar()` and `ComplexPolar::toRectangular()` methods.

## Basic usage

```php
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Imaginary, Complex, ComplexPolar};

$x = new ComplexPolar(4.27, Math::PI/4);
print("ComplexPolar(4.27, Math::PI/4) to string is {$x}\n"); // outputs ComplexPolar(4.27, Math::PI/4) to string is [4.27, φ 0.25π RAD]

$y = new ComplexPolar(3, Math::PI/6);

$sum = $x->add($y); // result is [6.93, φ 0.35π RAD]
$diff = $x->subtract($y); // result is [1.27, φ 0.15π RAD]
$prod = $x->multiply($y); // result is [12.81, φ 0.75π RAD]
$quotient = $x->divide($y); // result is [1.42, φ 0.083π RAD]
$reciprocal = $x->reciprocal(); // result is [0.234, φ -0.25π RAD]
$conjugate = $x->conjugate(); // result is [4.27, φ -0.25π RAD]
$magnitude = $x->abs(); // result is 4.27
$phase = $x->arg(); // result is 0.25π RAD
$pow = $x->pow(2); // result is [18.23, φ 0.5π RAD]
$exp = $x->exp(); // result is [71.8, φ 0.25π RAD]
$ln = $x->ln(); // result is [1.45, φ 0.25π RAD]

$is_empty = (new ComplexPolar(0, 0))->empty(); // true
$is_equal = $x->isEqual($x); // true
$is_near = $x->isNear(new ComplexPolar(4.27, Math::PI/4 + 0.0001)); // true
```

## Constructor

You can create an instance of a ComplexPolar number in different ways. This is something already familiar:
```php
$x = new ComplexPolar(4.27, Math::PI/4);
$y = new ComplexPolar(3, Math::PI/6);
```

You can pass an instance of Complex:
```php
$c = new Complex(4, 0.92);
$cp = new ComplexPolar($c);
```

And Scalar is acceptable as well (phase will be taken as zero):
```php
$s = new Scalar(-12);
$cps = new ComplexPolar($s);
```

Arrays passed to constructor are not refused at all:
```php
$cpa = new ComplexPolar([
	'radius' => 4,
	'phase' => 0.92,
]);
```

You can also create a copy of another ComplexPolar number:
```php
$cp1 = new ComplexPolar(2.5, Math::PI/3);
$cp2 = new ComplexPolar($cp1);
```

## Addition / Subtraction

As denoted above, there are methods for addition and subtraction of complex polar numbers:
```php
$x = new ComplexPolar(4.27, Math::PI/4);
$y = new ComplexPolar(3, Math::PI/6);
$sum = $x->add($y); // result is [6.93, φ 0.35π RAD]
$diff = $x->subtract($y); // result is [1.27, φ 0.15π RAD]
```

## Multiplication / Division

Complex polar number multiplication, division, obtaining reciprocal and conjugate methods are pretty straightforward:
```php
$prod = $x->multiply($y); // result is [12.81, φ 0.75π RAD]
$quotient = $x->divide($y); // result is [1.42, φ 0.083π RAD]
$reciprocal = $x->reciprocal(); // result is [0.234, φ -0.25π RAD]
$conjugate = $x->conjugate(); // result is [4.27, φ -0.25π RAD]
```

## Other methods

Natural logarithm:
```php
print (new ComplexPolar(2, Math::PI/3))->ln(); // outputs [0.693, φ 0.333π RAD]
```

Exponent:
```php
print (new ComplexPolar(1, Math::PI/4))->exp(); // outputs [2.718, φ 0.25π RAD]
```

## See also

- [Complex](./Complex.md)
- [Imaginary](./Imaginary.md)
- [Scalar](./Scalar.md)
- [Fraction](./Fraction.md)