<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Helpers\{Utils, Delegator};
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex, QuaternionComponent, Quaternion, Vector};
?>

<pre>
<?php
$x = new Complex(5, -3);
print("Complex to string is {$x}\n");
print("Real is {$x->real}, imaginary is {$x->imaginary}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$a = new Imaginary(-3);
$x = new Complex($a);
print("Complex to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($a, $x);
?>

<?php
$a = new Scalar(5);
$x = new Complex($a);
print("Complex to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($a, $x);
?>

<?php
$x = new Complex(2, 7);
$y = new Complex(3, 13);
$z = $x->add($y);
print("{$x} + {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Scalar(10);
$y = new Complex(3, 13);
$z = $x->add($y);
print("{$x} + {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(2, 7))->add(1.25);
	},
	check: '[3.25 + 7i]',
	descr: '(new Complex(2, 7))->add(1.25)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(2, 7))->add(new Scalar(1.25));
	},
	check: '[3.25 + 7i]',
	descr: '(new Complex(2, 7))->add(new Scalar(1.25))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(2, 7))->add(new Fraction('5/4'));
	},
	check: '[3.25 + 7i]',
	descr: '(new Complex(2, 7))->add(new Fraction(\'5/4\'))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(2, 7))->add(new Imaginary(7.32));
	},
	check: '[2 + 14.32i]',
	descr: '(new Complex(2, 7))->add(new Imaginary(7.32))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(2, 7))->add(new QuaternionComponent(13.2, 'k'));
	},
	check: '[2 + 7i + 0j + 13.2k]',
	descr: '(new Complex(2, 7))->add(new QuaternionComponent(13.2, \'k\'))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(2, 7))->add(new Quaternion([1, 2, 3, 4]));
	},
	check: '[3 + 9i + 3j + 4k]',
	descr: '(new Complex(2, 7))->add(new Quaternion([1, 2, 3, 4]))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(2, 7))->add(new Vector([1, 2, 3, 4]));
	},
	check: '?',
	descr: '(new Complex(2, 7))->add(new Vector([1, 2, 3, 4]))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(2, 7))->add(new Vector([1, 2, 3, 4]));
	},
	check: '?',
	descr: '(new Complex(2, 7))->add(new Matrix([[1, 2], [3, 4]]))'
);
?>

<?php
$x = new Complex(2, 7);
$z = $x->invert();
$y = $x->negative();
print("{$x} inverted is {$y} === {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Complex(4, 7);
$y = new Complex(-4, -7);
$z = $x->subtract($y);
print("{$x} - {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(3, 13))->subtract(-0.175);
	},
	check: '[3.175 + 13i]',
	descr: '(new Complex(3, 13))->subtract(-0.175)'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(3, 13))->subtract(new Scalar(-0.175));
	},
	check: '[3.175 + 13i]',
	descr: '(new Complex(3, 13))->subtract(new Scalar(-0.175))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(3, 13))->subtract(new Fraction('-7/40'));
	},
	check: '[3.175 + 13i]',
	descr: '(new Complex(3, 13))->subtract(new Fraction(\'-7/40\'))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(3, 13))->subtract(new Imaginary(-7/40));
	},
	check: '[3 + 13.175i]',
	descr: '(new Complex(3, 13))->subtract(new Imaginary(-7/40))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(3, 13))->subtract(new QuaternionComponent(-0.175, 'j'));
	},
	check: '[3 + 13i + 0.175j + 0k]',
	descr: '(new Complex(3, 13))->subtract(new QuaternionComponent(-0.175, \'j\'))'
);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(3, 13))->subtract(new Quaternion([9, -7, 5, -3]));
	},
	check: '[-6 + 20i + -5j + 3k]',
	descr: '(new Complex(3, 13))->subtract(new Quaternion([9, -7, 5, -3]))'
);
?>

<?php
$x = new Complex(10, 2);
$y = new Complex(10, 2);
$z = $x->subtract($y);
print("{$x} - {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Complex(4, 7);
$y = $x->negative();
$z1 = $x->abs();
$z2 = $y->abs();
print("{$x} and {$y} absolutes is {$z1} and {$z2}\n");
print("Type of z1 is ".($z1::class)."\n");
unset($x, $y, $z1, $z2);
?>

<?php
$x = new Complex(3, 2);
$y = new Complex(1, 4);
$z = $x->multiply($y);
print("{$x} * {$y} is {$z}\n");
print("Type of z is ".Delegator::getType($z)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Complex(2, 3);
$y = new Complex(2, -3);
$z = $x->divide($y);
print("{$x} / {$y} is {$z}\n");
print("Type of z is ".Delegator::getType($z)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Complex(3, 2);
$y = new Complex(3, -2);
$z = $x->divide($y);
print("{$x} / {$y} is {$z}\n");
print("Type of z is ".Delegator::getType($z)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Complex(3, 7);
$y = new Complex(-3, -7);
$z = $x->divide($y);
print("{$x} / {$y} is {$z}\n");
print("Type of z is ".Delegator::getType($z)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Complex(3.5, 17.3);
$y = $x->conjugate();
$z = $x->multiply($y);
$w = $y->multiply($x);
print("{$y} is conjugate of {$x}\n");
print("xx* = {$z}\n");
print("x*x = {$w}\n");
unset($x, $y, $z, $w);
?>

<?php
Utils::test(
	fn: function() {
		return (new Complex(2, 3))->ln();
	},
	// check: '[1.2824746787307684 + 0.982793723247329i]',
	check: '[1.2824746787308 + 0.98279372324733i]',
	descr: 'ln(2+3j)'
);
print "ref py: (1.2824746787307684+0.982793723247329j) \n\n";

Utils::test(
	fn: function() {
		return (new Complex(-0.7, 3.14))->ln();
	},
	// check: '[1.1684739358107776 + 1.7901395814000833i]',
	check: '[1.1684739358108 + 1.7901395814001i]',
	descr: 'ln(-0.7+3.14j)'
);
print "ref py: (1.1684739358107776+1.7901395814000833j) \n\n";

Utils::test(
	fn: function() {
		return (new Complex(32.5, -13.2))->exp()->ln();
	},
	// check: '[32.5-0.6336293856408264i]',
	check: '[32.5 + -13.2i]', // ln of exp should be the initial value, result is differ, but the same as NumPy gives. Investigate, why? because of +2π / -2π * k ?
	descr: 'ln(exp(32.5-13.2j))'
);
print "ref py: (32.5-0.6336293856408264j) \n\n";

Utils::test(
	fn: function() {
		return (new Complex(5, 6.27))->exp()->ln();
	},
	check: '[5 + 6.27i]',
	descr: 'ln(exp(5 + 6.27i))'
);

?>

<?php

Utils::test(
	fn: function() {
		return (new Complex(5, -3.14))->exp()->ln();
	},
	check: '[5 + -3.14i]',
	descr: 'ln(exp(5 + -3.14i))'
);

?>

<?php

Utils::test(
	fn: function() {
		return (new Complex(32.5, -13.2))->exp();
	},
	// check: '[104916349800311-77080814660213.08i]',
	check: '[1.0491634980031E+14 + -77080814660213i]',
	descr: 'exp(32.5-13.2j)'
);
print "ref py: (104916349800311-77080814660213.08j) \n\n";
?>
</pre>
