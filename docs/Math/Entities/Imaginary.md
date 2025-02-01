# Imaginary unit

This class models an imaginary number, providing operations for addition, subtraction, multiplication, division, exponentiation, and other essential functionalities.

It is not a big secret to be revealed that imaginary unit is a square root of -1:

$`i = √-1`$.

Since imaginary unit is a part of Complex number this class is not very useful by itself, it just represents gradual approach to its superset.

## Basic usage

```php
use irrevion\science\Math\Entities\Imaginary;

$x = new Imaginary(5);
print "Imaginary to string is {$x} (".($x::class).") \n"; // Output: Imaginary to string is 5i (irrevion\science\Math\Entities\Imaginary)

$y = new Imaginary(-3);
$sum = $x->add($y); // result is [2i]
$diff = $x->subtract($y); // result is [8i]
$prod = $x->multiply($y); // result is 15
$quotient = $x->divide($y); // result is [-1.6666666666667i]
$reciprocal = $x->reciprocal(); // result is [0.2i]
$conjugate = $x->conjugate(); // result is [-5i]
$invert = $x->invert(); // result is [-5i]
$magnitude = $x->abs(); // result is 5 type of Scalar
$square_root = $x->root(2); // result is [1.5811388300842 + 1.5811388300842i]
$pow = $x->pow(2); // result is [-25]
$exp = $x->exp(); // result is [0.28366218546323 + 0.95892427466314i]
$ln = $x->ln(); // result is [1.6094379124341 + 1.5707963267949i]

$is_empty = (new Imaginary(0))->empty(); // true
$is_equal = $x->isEqual($x); // true
$is_near = $x->isNear(new Imaginary(5.0000000000001)); // true
```

## Constructor

You can create an instance of an Imaginary number in different ways. The most trivial was already shown above:
```php
$x = new Imaginary(5);
$y = new Imaginary(-3);
```

You can also create a copy of another Imaginary number:
```php
$i1 = new Imaginary(0.7);
$i2 = new Imaginary($i1);
```

## Addition / Subtraction

As denoted above, there are methods for addition and subtraction of imaginary numbers:
```php
$x = new Imaginary(5);
$y = new Imaginary(-3);
$sum = $x->add($y); // result is [2i]
$diff = $x->subtract($y); // result is [8i]
```

## Multiplication / Division

Imaginary number multiplication, division, obtaining reciprocal and conjugate methods are pretty straightforward:
```php
$prod = $x->multiply($y); // result is [-15]
$quotient = $x->divide($y); // result is [-1.6666666666667i]
$reciprocal = $x->reciprocal(); // result is [0.2i]
$conjugate = $x->conjugate(); // result is [-5i]
```

## Other methods

Natural logarithm:
```php
print (new Imaginary(2))->ln(); // outputs [1.0986122886681 + 1.5707963267949i]
```

Exponent:
```php
print (new Imaginary(1))->exp(); // outputs [0.54030230586814 + 0.8414709848079i]
```

## See also

- [Complex](./Complex.md)
- [Scalar](./Scalar.md)
- [Fraction](./Fraction.md)