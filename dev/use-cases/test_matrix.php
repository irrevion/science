<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Helpers\Utils;
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

<?php
$x = new Matrix([
	[0.00, -0.2, 0.01],
	[0.00, 0.00, 2.03],
	[1.05, 0.00, 0.00],
]);
$z = $x->det();
print("det($x) is $z\n");
unset($x, $z);
// reference https://ru.onlinemschool.com/math/assistance/matrix/?oms_all=a%3d%7b%7b0,0,1.05%7d,%7b-0.2,0,0%7d,%7b0.01,2.03,0%7d%7d,b%3d%7b%7b5%7d,%7b55%7d,%7b-5%7d,%7b0%7d%7d
?>

<?php
$x = new Matrix([
	[2, -1, 0],
	[1,-3, 0],
	[0, 0, 1],
]);
$z = $x->det();
print("det($x) is $z\n");
unset($x, $z);
?>

<?php
$x = new Matrix([
	[3],
]);
$z = $x->det();
print("det($x) is $z\n");
unset($x, $z);
?>

<?php
$x = new Matrix([
	[2, -1, 0],
	[1,-3, 0],
	[0, 0, 1],
]);
$z = $x->determinant();
print("determinant($x) is $z\n");
// $y = new Matrix(Utils::arrayColumnsToAttributes($x->structure));
$y = $x->transpose();
$w = $y->determinant();
print("determinant($y) is $w\n");
unset($x, $z);
?>

<?php
$x = new Matrix([
	[2, -1, 0],
	[1,-3, 0],
	[0, new Complex(0, -3), new Complex(-1, -1)],
], 'irrevion\science\Math\Entities\Complex');
$z = $x->determinant();
print("determinant($x) is $z\n");
unset($x, $z);
?>
</pre>