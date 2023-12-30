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
$m = $y->map(fn($v) =>$v->multiply(-1));
print("mapped $y is $m \n");
//$i = $x->composeWith($y);
//print("$x composed with transponed itself $y is $i \n");
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

<?php
Utils::test(
	fn: function() {
		return new Matrix([[0]]);
	},
	check: function($res, $err) {
		return ($res->rows==1);
	},
	descr: 'new Matrix([[0]])'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 4], [5, 6]]))->minor(0, 0);
	},
	check: function($res, $err) {
		return (($res->rows==1) && ($res[0][0]->value==6));
	},
	descr: '(new Matrix([[3, 4], [5, 6]]))->minor(0, 0)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 4, 7], [5, 6, 8], [9, 10, 11]]))->minor(1, 1);
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[3, 7], [9, 11]] ]");
	},
	descr: 'M([[3, 4, 7], [5, 6, 8], [9, 10, 11]])->minor(1, 1)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 4, 7, 18, 19], [5, 6, 8, 20, 21], [9, 10, 11, 22, 23], [12, 13, 14, 24, 25], [15, 16, 17, 26, 27]]))->minor(2, 2);
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 4x4: [[3, 4, 18, 19], [5, 6, 20, 21], [12, 13, 24, 25], [15, 16, 26, 27]] ]");
	},
	descr: 'M([[3, 4, 7, 18, 19], [5, 6, 8, 20, 21], [9, 10, 11, 22, 23], [12, 13, 14, 24, 25], [15, 16, 17, 26, 27]])->minor(2, 2)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->cofactorMatrix();
	},
	check: function($res, $err) {
		print "matrix.py >>> [[ 4. -3.]  [-2.  1.]] \n";
		return ("$res"=="[ Matrix 2x2: [[4, -3], [-2, 1]] ]");
	},
	descr: 'M([[1, 2], [3, 4]])->cofactorMatrix()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 4, 5], [6, 7, 8], [9, 10, 11]]))->cofactorMatrix();
	},
	check: function($res, $err) {
		print "matrix.py >>> could not find cofactor matrix due to singular matrix \n";
		return ("$res"=="[ Matrix 3x3: [[-3, 6, -3], [6, -12, 6], [-3, 6, -3]] ]");
	},
	descr: 'M([[3, 4, 5], [6, 7, 8], [9, 10, 11]])->cofactorMatrix()'
);
/*
[[ -2.9993   5.9994  -3.    ]
 [  5.9996 -11.9997   6.    ]
 [ -3.       6.      -3.    ]]
*/
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 4, 7, 18, 19], [5, 6, 8, 20, 21], [9, 10, 11, 22, 23], [12, 13, 14, 24, 25], [15, 16, 17, 26, 27]]))->cofactorMatrix();
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 5x5: [[0, 0, 0, 0, 0], [0, 0, 0, 0, 0], [-4, 4, 0, 4, -4], [8, -8, 0, -8, 8], [-4, 4, 0, 4, -4]] ]");
	},
	descr: 'M([[3, 4, 7, 18, 19], [5, 6, 8, 20, 21], [9, 10, 11, 22, 23], [12, 13, 14, 24, 25], [15, 16, 17, 26, 27]])->cofactorMatrix()'
);
/*
[[ 4.40000000e-03 -4.40000000e-03 -2.00000000e-04  3.00000000e-04   8.34887715e-14]
 [-9.20000000e-03  9.60000000e-03  1.27897692e-17 -6.00000000e-04  -1.70530257e-13]
 [-3.99000000e+00  3.98920000e+00  6.00000000e-04  4.00050000e+00  -4.00000000e+00]
 [ 7.99520000e+00 -7.99480000e+00 -4.00000000e-04 -8.00020000e+00   8.00000000e+00]
 [-4.00000000e+00  4.00000000e+00  2.08722023e-18  4.00000000e+00  -4.00000000e+00]]
*/
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->reverseTransformation();
	},
	check: function($res, $err) {
		print "matrix.py >>> [[-2.   1. ]; [ 1.5 -0.5]] \n";
		return ("$res"=="[ Matrix 2x2: [[-2, 1], [1.5, -0.5]] ]");
	},
	descr: 'M([[1, 2], [3, 4]])->cofactorMatrix()'
);
/*
[[-2.   1. ]
 [ 1.5 -0.5]]
*/
?>
</pre>