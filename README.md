# science
PHP library for extended mathematical operations

## Killer-features and advantages:
- Improved pow() function
- Support for Complex numbers and Quaternions (just like Python with NumPy + ~~SciPy~~ + PyQuaternion)
- Physics units conversion (more units to be added...)

## Installation
Available on Packagist and could be installed using CLI command:
```
composer require irrevion/science
```

## Usage
If installed via composer include composer generated autoloader and add `use irrevion\science\Math\Math` statement for example.
If you are not using composer or using a custom folder you can modify and include (custom autoloader)[https://github.com/irrevion/science/blob/main/dev/autoloader.php].
Example:
```
require_once("../autoloader.php");

use irrevion\science\Helpers\Utils;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex};
```

## Examples
Scalar is a basic number class:
```
use irrevion\science\Math\Entities\Scalar;

$n = new Scalar(5);
print("Scalar to string is {$n}\nType of n is ".($n::class)."\n");
// Outputs:
// Scalar to string is 5
// Type of n is irrevion\science\Math\Entities\Scalar
```
Basic arithmetic operations available:
```
$sum = $n->add(new Scalar(3));
$diff = $n->subtract(new Scalar(2));
$prod = $n->multiply(new Scalar(10));
$quotient = $n->divide(new Scalar(3));
```