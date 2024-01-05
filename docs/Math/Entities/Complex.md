# Complex numbers

Complex numbers available at Math\Entities\Complex namespace:
```php
use irrevion\science\Math\Entities\Complex;
```

## Quick overview

```php
$x = new Complex(5, -3);

print "$x";
// Output: [5 + -3i]

$scalar = $x->real; // real part of Complex number type of Scalar
$rn = $x->getReal(); // real part of Complex number type of integer / float
$imaginary = $x->imaginary; // imaginary part of Complex number type of Imaginary
$in = $x->getImaginary(); // imaginary part of Complex number type of integer / float
$ik = $x->imaginary->toScalar(); // imaginary part of Complex number type of Scalar
$n = $x->toNumber(); // returns magnitude of Complex number vector type of integer / float
$polar = $x->toPolar(); // returns polar representation of Complex number (radius, phase) type of ComplexPolar
$x_arr = $x->toArray(); // returns array representation of Complex number as array ['real' => 5, 'imaginary' => -3]
$V = $x->toVector(); // returns 2D vector representation of Complex number type of Vector
$n_phi = $x->phase(); // returns phase of Complex number (angle in polar notation) as integer / float

$x = new Complex(2, 7);
$y = new Complex(3, 13);
$sum = $x->add($y); // result is [5 + 20i]
$diff = $x->subtract($y); // result is [-1 + -6i]
$prod = $x->multiply($y); // result is [-85 + 47i]
$quotient = $x->divide($y); // result is [0.54494382022472 + -0.028089887640449i]
$reciprocal = $x->reciprocal(); // result is [0.037735849056604 + -0.13207547169811i]
$conjugate = $x->conjugate(); // result is [2 + -7i]
$invert = $x->invert(); // result is [-2 + -7i], alias is $x->negative();
$magnitude = $x->abs(); // result is 7.2801098892805 type of Scalar
$square_root = $x->root(2); // result is [2.1540786765205 + 1.6248245888834i]
$roots = $x->roots(2); // result is [[2.1540786765205 + 1.6248245888834i], [-2.1540786765205 + -1.6248245888834i]] type of array of elements as Complex numbers
$pow = $x->pow(2); // result is [-45 + 28i]
$ipow = $x->powI($y); // result is [-3.1150080947398E-6 + -1.9211645035452E-5i]
$exp = $x->exp(); // result is [5.570626050453 + 4.8545108341788i]
$ln = $x->ln(); // result is [1.9851459567761 + 1.2924966677898i]

$is_empty = (new Complex(0, 0))->empty(); // true
$is_equal = $x->isEqual($x); // true
$is_near = $x->isNear(new Complex(2.0000000000001, 7)); // true
```

## Constructor

You can create instance of Complex number in a different ways.  
The most trivial was already shown above:
```php
$x = new Complex(5);
$y = new Complex(5, -3);
$z = new Complex(0, 29);
```
which is similar to
```php
$x = new Complex(new Scalar(5));
$y = new Complex(new Scalar(5), new Imaginary(-3));
$z = new Complex(new Imaginary(29));
```
> [!WARNING]
> It is not allowed to pass Scalar as second argument. Error will be thrown.

You can also create a copy of another Complex number including ComplexPolar form:
```php
$c1 = new Complex(-0.3, 0.7);
$c2 = new Complex($c1);

$cp = new ComplexPolar(12, Math::PI/2);
$c3 = new Complex($cp);
```

And some more exotic ways are available:
```php
$c4 = new Complex(['real' => 5.045, 'imaginary' => -9.3]);
$c5 = $cp->toRectangular();
$c6 = (new Scalar(5))->add(new Imaginary(-3));
$c7 = Math::pow(new Scalar(-42.42), new Fraction('1/3'));
$c8 = new Quaternion([5, -3, 0, 0])->toComplex();
```

## Addition / Subtraction

As denoted above there is methods for addition and subtraction for complex numbers
```
$x = new Complex(2, 7);
$y = new Complex(3, 13);
$sum = $x->add($y); // result is [5 + 20i]
$diff = $x->subtract($y); // result is [-1 + -6i]
```
Any non-complex value passed to this methods as argument will be converted to a complex number in a way that constructor called with only one argument does; or delegate operation to super type.
```
$sum1 = $x->add(1.25); // result is [3.25 + 7i] ( type of irrevion\science\Math\Entities\Complex )
$sum2 = $x->add(new Scalar(1.25)); // [3.25 + 7i] ( irrevion\science\Math\Entities\Complex )
$sum3 = $x->add(new Fraction('5/4')); // [3.25 + 7i] ( irrevion\science\Math\Entities\Complex )
$sum4 = $x->add(new Imaginary(7.32)); // [2 + 14.32i] ( irrevion\science\Math\Entities\Complex )
$sum5 = $x->add(new QuaternionComponent(13.2, 'k')); // [2 + 7i + 0j + 13.2k] ( irrevion\science\Math\Entities\Quaternion )
$sum6 = $x->add(new Quaternion([1, 2, 3, 4])); // [3 + 9i + 3j + 4k] ( irrevion\science\Math\Entities\Quaternion )
$sum7 = $x->add(new Vector([1, 2, 3, 4])); // Error thrown: This entities are incompatible
$sum8 = $x->add(new Matrix([[1, 2], [3, 4]])); // Error thrown: This entities are incompatible
```
Adding vector or matrix to a complex number currently breaks with error, but this behavior can be changed in future. Complex number representation in vector or matrix form is not obvious and clear, so let it be.