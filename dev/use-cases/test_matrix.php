<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/autoloader.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex, ComplexPolar, Vector};
use irrevion\science\Math\Transformations\Matrix;
?>

<pre>
<?php
$x = new Matrix([
	[1, 2],
	[3, 4]
]);
print("{$x} of {$x->inner_type}\n");
unset($x);
?>

<?php
$x = new Matrix([
	[1, 2],
	[3, 4]
]);
$v = new Vector([7, 3]);
$z = $x->applyTo($v);
print("$x * $v is $z\n");
unset($v, $x, $z);
?>

<?php
$x = new Matrix([
	[1, -2],
	[3, 0]
]);
$v = new Vector([-2, 3]);
$z = $x->applyTo($v);
print("$x * $v is $z\n");
unset($v, $x, $z);
?>

<?php
$x = new Matrix([
	[0.00, -0.2, 0.01],
	[0.00, 0.00, 2.03],
	[1.05, 0.00, 0.00],
]);
$v = new Vector([5, 55, -5]);
$z = $x->applyTo($v);
print("$x * $v is $z\n");
unset($v, $x, $z);
?>

<?php
$x = new Matrix([
	[0, 1],
	[-1, 0]
]); // rotation
$y = new Matrix([
	[1, 0],
	[1, 1]
]); // shear
$z = $x->composeWith($y);
print("$x * $y is $z\n");
unset($x, $y, $z);
?>
</pre>