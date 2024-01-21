<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Helpers\{Utils, R, M};
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
Utils::test(
	fn: function() {
		return (new Matrix([[3, 4], [5, 6]]))->isEqual(new Matrix([[3, 4], [5, 6]]));
	},
	check: function($res, $err) {
		return $res===true;
	},
	descr: '(new Matrix([[3, 4], [5, 6]]))->isEqual(new Matrix([[3, 4], [5, 6]]))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 4], [5, 6]]))->isEqual(new Matrix([[3, 4], [5, 6.0000000000001]]));
	},
	check: function($res, $err) {
		return $res===false;
	},
	descr: '(new Matrix([[3, 4], [5, 6]]))->isEqual(new Matrix([[3, 4], [5, 6.0000000000001]]))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 4], [5, 6]]))->isNear(new Matrix([[3, 4], [5, 6.0000000000001]]));
	},
	check: function($res, $err) {
		return $res===true;
	},
	descr: '(new Matrix([[3, 4], [5, 6]]))->isNear(new Matrix([[3, 4], [5, 6.0000000000001]]))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 4], [5, 6]]))->isNear(new Matrix([[3, 4], [5, 6.000000000001]]));
	},
	check: function($res, $err) {
		return $res===false;
	},
	descr: '(new Matrix([[3, 4], [5, 6]]))->isNear(new Matrix([[3, 4], [5, 6.000000000001]]))'
);
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

<?php
Utils::test(
	fn: function() {
		return Matrix::M('I');
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[1, 0], [0, 1]] ]");
	},
	descr: 'M("I")'
);
?>

<?php
Utils::test(
	fn: function() {
		return Matrix::fromTemplate('3x3', 'identity');
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 3x3: [[1, 0, 0], [0, 1, 0], [0, 0, 1]] ]");
	},
	descr: 'M("3x3", "I")'
);
?>

<?php
Utils::test(
	fn: function() {
		return Matrix::M('I', '23x23');
	},
	check: function($res, $err) {
		return $res->cols==23;
	},
	descr: 'M("I", "23x23")'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->pow(new Scalar(0.0));
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[1, 0], [0, 1]] ]");
	},
	descr: '(new Matrix([[1, 2], [3, 4]]))->pow(new Scalar(0.0))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->pow(1);
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[1, 2], [3, 4]] ]");
	},
	descr: '(new Matrix([[1, 2], [3, 4]]))->pow(1)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->pow(2);
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[7, 10], [15, 22]] ]");
	},
	descr: '(new Matrix([[1, 2], [3, 4]]))->pow(2)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->pow(-5);
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[-106.4375, 48.6875], [73.03125, -33.40625]] ]");
	},
	descr: '(new Matrix([[1, 2], [3, 4]]))->pow(-5)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->exp();
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[-106.4375, 48.6875], [73.03125, -33.40625]] ]");
	},
	descr: '(new Matrix([[1, 2], [3, 4]]))->exp()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->pow(64);
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[1.2833525361571E+46, 1.8703927750031E+46], [2.8055891625047E+46, 4.0889416986618E+46]] ]");
	},
	descr: '(new Matrix([[1, 2], [3, 4]]))->pow(64)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->pow(128);
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[6.8945474312366E+92, 1.0048300321996E+93], [1.5072450482994E+93, 2.1966997914231E+93]] ]");
	},
	descr: '(new Matrix([[1, 2], [3, 4]]))->pow(128)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->pow(256);
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[1.9898729332311E+186, 2.9000947538816E+186], [4.3501421308225E+186, 6.3400150640536E+186]] ]");
	},
	descr: '(new Matrix([[1, 2], [3, 4]]))->pow(256)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1, 2], [3, 4]]))->pow(512);
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [ Matrix 2x2: [[INF, INF], [INF, INF]] ] ]"); // yep, brokes here, but it was expected
	},
	descr: '(new Matrix([[1, 2], [3, 4]]))->pow(512)'
);
?>

<?php
Utils::test(
	fn: function() {
		return new R(3);
	},
	check: function($res, $err) {
		return ("$res"=="[0, 0, 0]");
	},
	descr: 'new R(3)'
);
?>

<?php
Utils::test(
	fn: function() {
		return [0.0, 0.0, 0.0];
	},
	check: function($res, $err) {
		return (Utils::printR($res)=="[0, 0, 0]");
	},
	descr: '[0.0, 0.0, 0.0]'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new R(12))->map(fn($v) => $v+rand());
	},
	check: function($res, $err) {
		return ($res->count()==12);
	},
	descr: '(new R(12))->map(fn($v) => $v+rand())'
);
?>

<?php
Utils::test(
	fn: function() {
		return Utils::map([0,0,0,0,0,0,0,0,0,0,0,0], fn($v) => $v+rand());
	},
	check: function($res, $err) {
		return (count($res)==12);
	},
	descr: 'Utils::map(arr(12), fn($v) => $v+rand())'
);
?>

<?php
Utils::test(
	fn: function() {
		$nat_pow = (new Matrix([[1, 2], [3, 4]]))->methodPowNaturalMultiply(3);
		return $nat_pow;
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[37, 54], [81, 118]] ]");
	},
	descr: 'M([[1, 2], [3, 4]]))->methodPowNaturalMultiply(3)'
);
?>

<?php
/*
Utils::test(
	fn: function() {
		$nat_pow = (new Matrix([[1, 2], [3, 4]]))->methodPowDeterminant(3);
		return $nat_pow;
	},
	check: function($res, $err) {
		return ("$res"=="[ Matrix 2x2: [[37, 54], [81, 118]] ]");
	},
	descr: 'M([[1, 2], [3, 4]]))->methodPowDeterminant(3)'
);
*/
?>

<?php
Utils::test(
	fn: function() {
		$M = new Matrix([[1, 2], [3, 4]]);
		$D = $M->determinant();
		$M_adj = $M->adjugate();
		$M_v = $M->divideScalar($D);
		$M_v2 = Matrix::M('I')->multiply($M_adj->reverseTransformation());
		return [$M_v, $M_v2];
	},
	check: function($res, $err) {
		return ($res[0]==$res[1]);
	},
	descr: '$M_v==$M_v2'
);
?>


Row Echelon Form (Gaussian elimination) tests

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1,2], [3,4]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		if (is_null($res)) {
			print "No response\n";
			return;
		}
		print "result is $res \n";
		print "sympy & emathhelp.net: [[1, 0], [3, -2]]\n"; // wrong: 3. The leading entry in any nonzero row is 1.
		print "mathhelpplanet.com & atozmath.com: [[1, 0], [3, 1]]\n";
		$is_ref = $res->isREF();
		print "is".($is_ref? '': ' not')." REF\n";
		return ("$res"=="[[1, 0], [3, -2]]");
	},
	descr: 'M([[1,2], [3,4]])->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 2], [9, 4]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		return ("$res"=="[[1, 0], [3, 1]]");
	},
	descr: 'M([[3, 9], [2, 4]])->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3,2], [1,1], [2,3]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		print "wolframalpha.com: [[1, 0], [0, 1], [-1, 5]]]\n";
		return ("$res"=="[[1, 0], [0, 1], [-1, 5]]");
	},
	descr: 'M([[3,2], [1,1], [2,3]])->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[0,2], [2,4], [3,6]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		return ("$res"=="[[1, 0], [2, 1], [3, 1.5]]");
	},
	descr: 'M([[0,2], [2,4] [3,6]])->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1,1,3], [1,2,4], [2,3,5]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		return ("$res"=="[[1, 0, 0], [1, 1, 0], [2, 1, -2]]");
	},
	descr: 'M([[1,1,3], [1,2,4], [2,3,5]])->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[2,3,6], [4,5,7]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		print "res: $res\n";
		$is_ref = $res->isREF();
		print "is".($is_ref? '': ' not')." REF\n";
		return ("$res"=="[[1, 0, 0], [2, 1, 0]]");
	},
	descr: 'M([[2,3,6], [4,5,7]])->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[0,0,0,0], [1,1,2,4], [1,1,2,4], [1,2,1,4], [1,3,2,6], [1,2,1,4]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		print "correct answer [[0,0,0,0], [1,0,0,0], [1,0,0,0], [1,1,0,0], [1,2,2,0], [1,1,0,0]]\n";
		//return ("$res"=="[[0, 1, 1, 1, 1, 1], [0, 0, 0, 1, 2, 1], [0, 0, 0, 0, 2, 0], [0, 0, 0, 0, 0, 0]]"); // sympy
		return ("$res"=="[[0, 0, 0, 0], [1, 0, 0, 0], [1, 0, 0, 0], [1, 1, 0, 0], [1, 2, 2, 0], [1, 1, 0, 0]]"); // sympy reshaped
		return ("$res"=="[[0, 0, 0, 0], [1, 0, 0, 0], [1, 0, 0, 0], [1, 1, 0, 0], [1, 2, 1, 0], [1, 1, 0, 0]]"); // actual result
	},
	descr: 'M([[0,0,0,0], [1,1,2,4], [1,1,2,4], [1,2,1,4], [1,3,2,6], [1,2,1,4]])->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[0, 17.5, 2], [1.5, -3, 52], [-92, 2.05, 3.11]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		return ("$res"=="[]");
	},
	descr: 'M([[0, 17.5, 2], [1.5, -3, 52], [-92, 2.05, 3.11]]))->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[69, 4, 7], [0, 17, 3], [-1, 2.05, 511]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		return ("$res"=="[[69, 4, 7], [0, 17, 3], [-1, 2.05, 511]]");
	},
	descr: 'M([[69, 4, 7], [0, 17, 3], [-1, 2.05, 511]]))->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[9,8,7,6,5,4,3,2,1,0], [9,8,7,6,5,11,3,2,1,0], [9,13,7,6,5,4,3,2,1,0], [9,8,7,6,5,4,3,2,17,0], [9,8,7,6,5,4,3,2,1,21], [55,8,7,6,5,4,3,2,1,0], [9,8,7,6,5,4,3,34,1,0], [9,8,0.5,6,5,4,3,2,1,0], [9,8,7,6,5,16,3,2,1,0], [9,8,7,36,5,4,3,2,1,0]]))->toRowEchelonForm();
	},
	check: '?',
	/*check: function($res, $err) {
		return ("$res"=="[]");
	},*/
	descr: 'M(10x10)->toRowEchelonForm()'
);
?>


Reduced Row Echelon Form (Gauss-Jordan elimination) tests

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1,2], [3,4]]))->toRREF();
	},
	check: function($res, $err) {
		if (is_null($res)) {
			print "No response\n";
			return;
		}
		print "result is $res \n";
		print "emathhelp.net: [[1, 0], [0, 1]]\n";
		$is_rref = $res->isRREF();
		print "is".($is_rref? '': ' not')." RREF\n";
		return ("$res"=="[ Matrix 2x2: [[1, 0], [0, 1]] ]");
	},
	descr: 'M([[1,2], [3,4]])->toRREF()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3, 2], [9, 4]]))->toRREF();
	},
	check: function($res, $err) {
		print "res: $res\n";
		$is_rref = $res->isRREF();
		print "is".($is_rref? '': ' not')." RREF\n";
		$rank = $res->rank();
		print "rank is $rank \n";
		return ("$res"=="[ Matrix 2x2: [[1, 0], [0, 1]] ]");
	},
	descr: 'M([[3, 9], [2, 4]])->toRREF()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[3,2], [1,1], [2,3]]))->toRREF();
	},
	check: function($res, $err) {
		print "wolframalpha.com: [[1, 0], [0, 1], [-1, 5]]]\n";
		print "res: $res\n";
		$is_rref = $res->isRREF();
		print "is".($is_rref? '': ' not')." RREF\n";
		return ("$res"=="[ Matrix 2x3: [[1, 0], [0, 1], [-1, 5]] ]");
	},
	descr: 'M([[3,2], [1,1], [2,3]])->toRREF()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[0,2], [2,4], [3,6]]))->toRREF();
	},
	check: function($res, $err) {
		print "res: $res\n";
		$is_rref = $res->isRREF();
		print "is".($is_rref? '': ' not')." RREF\n";
		return ("$res"=="[ Matrix 2x3: [[1, 0], [0, 1], [0, 1.5]] ]");
	},
	descr: 'M([[0,2], [2,4] [3,6]])->toRREF()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[1,1,3], [1,2,4], [2,3,5]]))->toRREF();
	},
	check: function($res, $err) {
		print "res: $res\n";
		$is_rref = $res->isRREF();
		print "is".($is_rref? '': ' not')." RREF\n";
		$rank = $res->rank();
		print "rank is $rank \n";
		return ("$res"=="[ Matrix 3x3: [[1, 0, 0], [0, 1, 0], [0, 0, 1]] ]");
	},
	descr: 'M([[1,1,3], [1,2,4], [2,3,5]])->toRREF()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[2,3,6], [4,5,7]]))->toRREF();
	},
	check: function($res, $err) {
		print "res: $res\n";
		$is_ref = $res->isREF();
		print "is".($is_ref? '': ' not')." REF\n";
		$is_rref = $res->isRREF();
		print "is".($is_rref? '': ' not')." RREF\n";
		$rank = $res->rank();
		print "rank is $rank \n";
		return ("$res"=="[ Matrix 3x2: [[1, 0, 0], [0, 1, 0]] ]");
	},
	descr: 'M([[2,3,6], [4,5,7]])->toRREF()'
);
?>

<?php /*
Utils::test(
	fn: function() {
		return (new Matrix([[0,0,0,0], [1,1,2,4], [1,1,2,4], [1,2,1,4], [1,3,2,6], [1,2,1,4]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		print "correct answer [[0,0,0,0], [1,0,0,0], [1,0,0,0], [1,1,0,0], [1,2,2,0], [1,1,0,0]]\n";
		//return ("$res"=="[[0, 1, 1, 1, 1, 1], [0, 0, 0, 1, 2, 1], [0, 0, 0, 0, 2, 0], [0, 0, 0, 0, 0, 0]]"); // sympy
		return ("$res"=="[[0, 0, 0, 0], [1, 0, 0, 0], [1, 0, 0, 0], [1, 1, 0, 0], [1, 2, 2, 0], [1, 1, 0, 0]]"); // sympy reshaped
		return ("$res"=="[[0, 0, 0, 0], [1, 0, 0, 0], [1, 0, 0, 0], [1, 1, 0, 0], [1, 2, 1, 0], [1, 1, 0, 0]]"); // actual result
	},
	descr: 'M([[0,0,0,0], [1,1,2,4], [1,1,2,4], [1,2,1,4], [1,3,2,6], [1,2,1,4]])->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[0, 17.5, 2], [1.5, -3, 52], [-92, 2.05, 3.11]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		return ("$res"=="[]");
	},
	descr: 'M([[0, 17.5, 2], [1.5, -3, 52], [-92, 2.05, 3.11]]))->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[69, 4, 7], [0, 17, 3], [-1, 2.05, 511]]))->toRowEchelonForm();
	},
	check: function($res, $err) {
		return ("$res"=="[[69, 4, 7], [0, 17, 3], [-1, 2.05, 511]]");
	},
	descr: 'M([[69, 4, 7], [0, 17, 3], [-1, 2.05, 511]]))->toRowEchelonForm()'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Matrix([[9,8,7,6,5,4,3,2,1,0], [9,8,7,6,5,11,3,2,1,0], [9,13,7,6,5,4,3,2,1,0], [9,8,7,6,5,4,3,2,17,0], [9,8,7,6,5,4,3,2,1,21], [55,8,7,6,5,4,3,2,1,0], [9,8,7,6,5,4,3,34,1,0], [9,8,0.5,6,5,4,3,2,1,0], [9,8,7,6,5,16,3,2,1,0], [9,8,7,36,5,4,3,2,1,0]]))->toRowEchelonForm();
	},
	check: '?',
	check: function($res, $err) {
		return ("$res"=="[]");
	},
	descr: 'M(10x10)->toRowEchelonForm()'
); */
?>
</pre>