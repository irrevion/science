# science
PHP library for extended mathematical operations. Its mostly focused on operations with Complex numbers, Quaternions and Linear Algebra.

## Key features and advantages
- Improved `Math::pow($base, $exponent)` function, able to raise any real or complex number to any real or complex exponent
- Support for [Complex](docs/Math/Entities/Complex.md) numbers and Quaternions ( just like Python with [NumPy](https://numpy.org/) + [PyQuaternion](http://kieranwynn.github.io/pyquaternion/) + [SymPy](https://www.sympy.org/) )
- Physics units conversion (more units to be added...) using `(new Quantity(0.7, IAU::parsec))->convert(SI::metre)`

## Installation
Library is available on [Packagist](https://packagist.org/packages/irrevion/science) and could be installed using CLI command:
```bash
composer require irrevion/science
```

## Usage
If installed via composer include composer generated autoloader and add `use irrevion\science\Math\Math` statement for example.  
If you are not using composer or using a custom folder you can modify and include [custom autoloader](https://github.com/irrevion/science/blob/main/dev/autoloader.php).  
Example:
```php
require_once("../autoloader.php");

use irrevion\science\Helpers\Utils;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex};
```

## Examples
Scalar is a basic number class:
```php
use irrevion\science\Math\Entities\Scalar;

$n = new Scalar(5);
print("Scalar to string is {$n}\nType of n is ".($n::class)."\n");
// Outputs:
// Scalar to string is 5
// Type of n is irrevion\science\Math\Entities\Scalar
```
Basic arithmetic operations available:
```php
$sum = $n->add(new Scalar(3));
$diff = $n->subtract(new Scalar(2));
$prod = $n->multiply(new Scalar(10));
$quotient = $n->divide(new Scalar(3));
```
As mentioned above, significant enhancement of pow() function has been made:
```php
use irrevion\science\Helpers\Utils;
use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex};

$x = 2;
$y = 3;
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} ( ".Delegator::getType($z)." ) \n";
// Output: 2**3 is 8 ( integer )

$x = new Scalar(25);
$y = new Scalar(2);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} ( ".($z::class)." ) \n";
// Output: 25**2 is 625 ( irrevion\science\Math\Entities\Scalar )

$x = new Scalar(25);
$y = new Scalar(-2);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} ( ".($z::class)." ) \n";
// Output: 25**-2 is 0.0016 ( irrevion\science\Math\Entities\Scalar )

$x = new Scalar(-1.678903);
$y = new Scalar(-2.5);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} ( ".($z::class)." ) \n";
// Output: -1.678903**-2.5 is [8.3827564317097E-17 + -0.27380160345158i] ( irrevion\science\Math\Entities\Complex )
// Vanilla PHP will give you: NAN
// Python will give you: (8.382756431709652e-17-0.2738016034515765j)

$x = new Scalar(Math::E);
$y = new Imaginary(Math::PI);
$z = Math::pow($x, $y);
print "e**πi is {$z} ( ".($z::class)." ) \n";
// Output: e**πi is [-1 + 1.2246467991474E-16i] ( irrevion\science\Math\Entities\Complex )
// Python gives: (-1+1.2246467991473532e-16j)
// Expected: -1 by formulae e**πi+1=0

$x = new Scalar(125);
$y = new Fraction('1/3');
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} ( ".($z::class)." ) \n";
// Output: 125**1/3 is 5 ( irrevion\science\Math\Entities\Scalar )

$x = new Scalar(4);
$y = new Complex(2.5, 2);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} ( ".($z::class)." ) \n";
// Output: 4**(2.5+2i) is [-29.845986458754 + 11.541970902054i] ( irrevion\science\Math\Entities\Complex )
// Python gives: (-29.845986458754275+11.541970902053793j)
```
It is also possible to get all roots of a number
```php
$roots = (new Complex(-64))->roots(3);
print Utils::printR($roots)." \n";
// Output: [[2 + 3.4641016151378i], [-4 + 4.8985871965894E-16i], [2 + -3.4641016151378i]]
```
So, as you can see, the following operations are supported:
- raise of real number to a real power
- raise of real number to a fractional power (2/3 means cubic root squared)
- raise of negative number to a rational or real power (1/n is n-th root of a number)
- raise of an any number to negative power (rational or real)
- raise of a number to imaginary or complex power
- raise of an any available value (entity-type instance: mixed/numeric, Scalar, Fraction, Imaginary, [Complex](docs/Math/Entities/Complex.md), ComplexPolar, QuaternionComponent, Quaternion, Vector, etc) at least to positive integer power

## Versions history

~dev-main
- Symbolic math implementation started
- Physics: Added Rydberg energy, kilometre, attometre, angstrom and Bohr radius units

v0.0.5
- Matrix inversion implemented (as well as methods for finding cofactor matrix, adjugate, minors, row echelon form, reduced REF, rank)
- Complex power, exponentiation, natural logarythm implemented
- Quaternions added
- Physics: Added units Dalton, Apostilb, Planck energy

v0.0.4
- Vector checking methods added (orthogonal, collinear, coplarar)
- Angle between vectors calculation added
- Physics: Angle units added

v0.0.3
- Matrix determinant implemented
- Physics: New units added (Ohm, Farad, Watt, etc)

v0.0.2
- Added units in physics
- Fixed fallback autoloader
- Implemented search by unit entity in physical unit categories

v0.0.1
- Basic entities implemented
- Composer requirements are met



## Documentation

- [Math](docs/Math/Math.md)
	- Numbers, Entities & Matrices
		- [NaN](docs/Math/Entities/NaN.md)
		- [Scalar](docs/Math/Entities/Scalar.md)
		- [Fraction](docs/Math/Entities/Fraction.md)
		- [Imaginary](docs/Math/Entities/Imaginary.md)
		- [Complex](docs/Math/Entities/Complex.md)
		- [ComplexPolar](docs/Math/Entities/ComplexPolar.md)
		- [QuaternionComponent](docs/Math/Entities/QuaternionComponent.md)
		- [Quaternion](docs/Math/Entities/Quaternion.md)
		- Vector
		- [Matrix](docs/Math/Transformations/Matrix.md)
	- Symbolic Math
		- [Symbols](docs/Math/Symbols/Symbols.md)
		- Operations
		- [Expressions](docs/Math/Symbols/Expressions.md)
- [Physics](docs/Physics/Physics.md)
	- [Quantity](docs/Physics/Entities/Quantity.md)
- Helpers
	- Utils - misc func toolbox
	- [R - array-like object constructor](docs/Helpers/R.md)
	- M - 2-dimensional R
