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