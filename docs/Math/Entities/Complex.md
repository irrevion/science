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

As denoted above there are methods for addition and subtraction of complex numbers
```php
$x = new Complex(2, 7);
$y = new Complex(3, 13);
$sum = $x->add($y); // result is [5 + 20i]
$diff = $x->subtract($y); // result is [-1 + -6i]
```
Any non-complex value passed to this methods as argument will be converted to a complex number in a way that constructor called with only one argument does; or delegate operation to super type.
```php
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

Tha same can be told about subtraction.
```php
$diff1 = $y->subtract(-0.175); // [3.175 + 13i] ( irrevion\science\Math\Entities\Complex )
$diff2 = $y->subtract(new Scalar(-0.175)); // [3.175 + 13i] ( irrevion\science\Math\Entities\Complex )
$diff3 = $y->subtract(new Fraction('-7/40')); // [3.175 + 13i] ( irrevion\science\Math\Entities\Complex )
$diff4 = $y->subtract(new Imaginary(-7/40)); // [3 + 13.175i] ( irrevion\science\Math\Entities\Complex )
$diff5 = $y->subtract(new QuaternionComponent(-0.175, 'j')); // [3 + 13i + 0.175j + 0k] ( irrevion\science\Math\Entities\Quaternion )
$diff6 = $y->subtract(new Quaternion([9, -7, 5, -3])); // [-6 + 20i + -5j + 3k] ( irrevion\science\Math\Entities\Quaternion )
$diff7 = $y->subtract(new Vector([12, 6, 3, 1.5])); // Error thrown: This entities are incompatible
$diff8 = $y->subtract(new Matrix([[0.22, 0.267], [-5.4, -5.3]])); // Error thrown: This entities are incompatible
```
Subtraction is implemented as adding negative of complex number ( opposite radius-vector on complex plane ). Such negative value can be obtained using `$x->invert()` or `$x->negative()` method. Keep in mind that complex number cannot be negative because unlike scalar/real numbers they form unordered set ( cant be compared to each other ).
```php
$x = new Complex(5, -3); // [5 + -3i]
$y = $x->negative(); // [-5 + 3i]
$is_negative_y = Math::isNegative($y); // false
$is_negative_x = Math::isNegative($x); // false
```
The reason why this check if number is negative returns `false` is because the numerical representation of complex number is radius-vector magnitude. Radius always considered as positive value. There are such a polar coordinate representations existing in other sources where radius can be negative if phase angle greater than π radian to keep phase always positive in range from 0 to π, but in this library radius is always positive and phase range is 0≤φ<2π. So you can either check if real part of complex number is negative or the phase angle is negative that way:
```php
$is_negative = Math::isNegative($y->real); // true
$is_negative = Math::compare($y->phase(), '>', Math::PI); // false
```
It is also possible to check if complex number equals 0 or close to 0:
```php
$z = new Complex(1e-13);
$is_zero = $z->empty(); // false
$is_zero = $z->isEqual(new Complex(0)); // false
$is_zero = $z->isNear(new Complex(0)); // true
```


## Multiplication / Division

Complex number multiplication, division, obtaining reciprocal and conjugate methods are pretty straitforward:
```php
$prod = $x->multiply($y); // result is [-85 + 47i]
$quotient = $x->divide($y); // result is [0.54494382022472 + -0.028089887640449i]
$reciprocal = $x->reciprocal(); // result is [0.037735849056604 + -0.13207547169811i]
$conjugate = $x->conjugate(); // result is [2 + -7i]
```


## Other methods

Natural logarythm:
```php
print (new Complex(2, 3))->ln() // outputs [1.2824746787308 + 0.98279372324733i]
// the reference result obtained in Python is (1.2824746787307684+0.982793723247329j)
```
Exponent:
```php
print (new Complex(32.5, -13.2))->exp(); // outputs [1.0491634980031E+14 + -77080814660213i]
// the reference result obtained in Python is (104916349800311-77080814660213.08j)
```

Despite $`ln(x)`$ and $`exp(x)`$ are reverse operations, result of combining them can be different from initial value $` x ≠ ln(exp(x)) `$. It occurs when imaginary part is out of π:-π range. Imaginary number in exponentiation operation can be interpreted as rotation of vector on the complex plane and imaginary numbers out of [π:-π] range just repeats those revolutions.
That means $`ln(exp(5 + 6.27i)) = [5 - 0.013185307179587i]`$ because 6.27 radian counter-clockwise is 0.01318 radian clockwise.
```php
print (new Complex(32.5, -13.2))->exp()->ln(); // outputs [32.5 + -0.63362938564083i]
print (new Complex(5, -3.14))->exp()->ln(); // outputs [5 + -3.14i]
```

There are separate methods for getting one root, all roots (as array), real power and complex power:
```php
$square_root = $x->root(2); // result is [2.1540786765205 + 1.6248245888834i]
$roots = $x->roots(2); // result is [[2.1540786765205 + 1.6248245888834i], [-2.1540786765205 + -1.6248245888834i]] type of array of elements as Complex numbers
$pow = $x->pow(2); // result is [-45 + 28i]
$ipow = $x->powI($y); // result is [-3.1150080947398E-6 + -1.9211645035452E-5i]
```
it is possible for them to be combined into one method in the future.


## See also

- [ComplexPolar](./ComplexPolar.md)
- [Imaginary](./Imaginary.md)
- [Scalar](./Scalar.md)
- [Fraction](./Fraction.md)