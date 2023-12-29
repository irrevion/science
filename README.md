# science
PHP library for extended mathematical operations

## Killer-features and advantages:
- Improved pow() function
- Support for Complex numbers and Quaternions (just like Python with [NumPy](https://numpy.org/doc/stable/user/quickstart.html) + ~~SciPy~~ + [PyQuaternion](http://kieranwynn.github.io/pyquaternion/)
- Physics units conversion (more units to be added...)

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