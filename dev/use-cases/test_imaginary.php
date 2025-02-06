<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Helpers\{Utils, Delegator};
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex};
?>

<pre>
<?php
$x = new Imaginary(5);
print "Imaginary to string is {$x} (".($x::class).") \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$y = new Imaginary(3);
		$z = $x->add($y);
		return $z;
	},
	check: function($res, $err) {
		return (new Imaginary(8))->equals($res);
	},
	descr: '5i add 3i'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$y = new Imaginary(-3);
		$z = $x->add($y);
		return $z;
	},
	check: function($res, $err) {
		return (new Imaginary(2))->equals($res);
	},
	descr: '5i add -3i'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$y = new Imaginary(-3);
		$z = $x->subtract($y);
		return $z;
	},
	check: function($res, $err) {
		return (new Imaginary(8))->equals($res);
	},
	descr: '5i subtract -3i'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$y = new Imaginary(3);
		$z = $x->multiply($y);
		return $z;
	},
	check: function($res, $err) {
		return (new Scalar(-15))->equals($res);
	},
	descr: '5i multiply 3i'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$y = new Imaginary(-3);
		$z = $x->multiply($y);
		return $z;
	},
	check: function($res, $err) {
		return (new Scalar(15))->equals($res);
	},
	descr: '5i multiply -3i'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$y = new Imaginary(-3);
		$z = $x->divide($y);
		return $z;
	},
	check: function($res, $err) {
		return (new Scalar(-1.6666666666667))->almost($res);
	},
	descr: '5i divide -3i'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$z = $x->reciprocal($x);
		return $z;
	},
	check: function($res, $err) {
		$ref = (new Complex(0, 5))->reciprocal();
		print "Reciprocal should be $ref \n";
		$ref = (new Complex(0, 5))->pow(-1);
		print "Reciprocal (2) should be $ref \n";
		$ref = (new Scalar(1))->divide(new Imaginary(5));
		print "Reciprocal (3) should be $ref : ".$ref::class." \n";
		return $ref->equals($res);
	},
	descr: 'reciprocal of 5i number'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$z = $x->pow(-1);
		return $z;
	},
	check: function($res, $err) {
		$ref = (new Complex(0, 5))->pow(-1);
		print "power -1 should be $ref \n";
		//$ref = Math::pow((new Imaginary(5)), -1);
		//print "#2. power -1 should be $ref \n";
		print "power -1 in fact is $res : ".$res::class." \n";
		return $ref->almost($res);
	},
	descr: 'reciprocal as -1 power of 5i number'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$z = $x->conjugate();
		return $z;
	},
	check: function($res, $err) {
		$ref = (new Complex(0, 5))->conjugate();
		print "conjugate of 5i should be $ref \n";
		// $ref = (new Complex(0, 5))->toPolar()->conjugate()->toRectangular();
		// print "conjugate (2) of 5i should be $ref \n";
		print "conjugate of 5i in fact is $res : ".$res::class." \n";
		return $ref->equals($res);
	},
	descr: 'conjugate of 5i number'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$z = $x->invert();
		return $z;
	},
	check: function($res, $err) {
		$ref = (new Complex(0, 5))->invert();
		return $ref->equals($res);
	},
	descr: 'negative of 5i number'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$z = $x->invert();
		return $z;
	},
	check: function($res, $err) {
		$ref = (new Complex(0, 5))->invert();
		return $ref->equals($res);
	},
	descr: 'negative of 5i number'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(-12);
		$z = $x->negative();
		return $z;
	},
	check: function($res, $err) {
		$ref = (new Imaginary(-12))->invert();
		return $ref->equals($res);
	},
	descr: 'negative of -12i number'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(-7);
		$z = $x->abs();
		return $z;
	},
	check: function($res, $err) {
		$ref = (new Scalar(7))->abs();
		return $ref->equals($res);
	},
	descr: 'abs of -7i number'
);
?>

<?php
/*
Utils::test(
	fn: function() {
		$x = new Imaginary(-7);
		$z = $x->root(2);
		return $z;
	},
	check: function($res, $err) {
		$ref = Math::pow(new Imaginary(-7), new Fraction('1/2'));
		return $ref->equals($res);
	},
	descr: 'root of -7i number'
);
*/
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$z = $x->exp();
		return $z;
	},
	check: function($res, $err) {
		return ("{$res}"=="[0.28366218546323 + -0.95892427466314i]"); // python: (0.28366218546322625-0.9589242746631385j)
	},
	descr: 'exp() of 5i number'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(-7);
		$z = $x->exp();
		return $z;
	},
	check: function($res, $err) {
		return ("{$res}"=="[0.7539022543433 + -0.65698659871879i]"); // python: (0.7539022543433046-0.6569865987187891j)
	},
	descr: 'exp() of -7i number'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(-16.4);
		$z = $x->ln();
		return $z;
	},
	check: function($res, $err) {
		return ("{$res}"=="[2.7972813348302 + -1.5707963267949i]"); // python: (2.797281334830153-1.5707963267948966j)
	},
	descr: 'ln() of -16.4i number'
);
?>

<?php
Utils::test(
	fn: function() {
		$x = new Imaginary(5);
		$z = $x->ln();
		return $z;
	},
	check: function($res, $err) {
		return ("{$res}"=="[1.6094379124341 + 1.5707963267949i]");
	},
	descr: 'ln() of 5i number'
);
?>

<?php
$x = new Imaginary(5);
$y = new Imaginary(3);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref py: (0.0010390549422230513-0.00892299738862152j) \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(1);
$y = new Scalar(5);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref py: 1j \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(1);
$y = new Scalar(99999998);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref: -1 \n";
print "ref py: (-0.9999999999999999+1.755727691898258e-08j) \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(1);
$y = new Scalar(0);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref: 1 \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(1);
$y = new Scalar(1);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref: i \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(1);
$y = new Scalar(2);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref: -1 \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(1);
$y = new Scalar(3);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref: -i \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(1);
$y = new Scalar(4);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref: 1 \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(1);
$y = new Scalar(6);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref: -1 \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(1);
$y = new Scalar(7);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref: -i \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
// 1.0000001j**283967013 in python is (75204.5433688295+2150453565990.7637j) the real part is non-0 because of growing float error, thats why power value is decreased
$x = new Imaginary(1.0000001);
$y = new Scalar(28367013);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref py: (6.074069914817451e-08+17.059396389624425j) \n";
print "ref complex: ".(new Complex(new Imaginary(1.0000001)))->pow($z)." \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Scalar(1.0000001);
$y = new Imaginary(283967013);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref py: (-0.9925226164252797-0.1220608695869281j) \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(25);
$y = new Scalar(0.2);
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref py: (1.8104824831866713+0.5882614184720111j) \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(64);
$y = new Fraction('1/3');
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref py: (3.4641016151377544+1.9999999999999996j) \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(-64);
$y = new Fraction('1/3');
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref py: (-3.4641016151377544-1.9999999999999996j) \n";
$all_roots = (new Complex($x))->roots(3);
print "ref complex: ".Utils::printR($all_roots)." \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(-64);
$y = new Fraction('-1/3');
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} (".($z::class).") \n";
print "ref py: (-0.21650635094610968+0.12499999999999999j) \n";
$all_roots = (new Complex($x))->roots(-3);
print "ref complex: ".Utils::printR($all_roots)." \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>
</pre>
