<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Helpers\{Utils, R};
use irrevion\science\Math\Entities\{Scalar, Imaginary};
?>

<pre>
<?php
print Math::PI."\n";
print (Math::TAU / Math::PI)."\n";
print Math::E."\n";
print Math::abs(-3)."\n";
?>

<?php
Utils::test(
	fn: function() {
		$e = new Scalar(Math::E);
		$i = new Imaginary(1);
		$π = new Scalar(Math::PI);
		return Math::pow($e, $i->multiply($π))->add(1);
	},
	check: function($res, $err) {
		//return $res->isNear(Delegator::wrap(0, $res::class));
		return Math::compare($res, '=', 0);
	},
	descr: 'Math::pow($e, $i->multiply($π))->add(1)'
);
?>

<?php
$polar = Math::rectangular2polar(-4, -12);
print "Rectangular coord [-4, -12] to Polar\n";
var_dump($polar);
$rect = Math::polar2rectangular($polar[0], $polar[1]);
print "Restored:\n";
var_dump($rect);
unset($polar, $rect);
?>

<?php
$rect = Math::polar2rectangular(5, Math::PI);
print "Polar coord [5, pi] to Rectangular\n";
var_dump($rect);
$polar = Math::rectangular2polar($rect[0], $rect[1]);
print "Restored:\n";
var_dump($polar);
unset($rect);
?>

<?php
$rect = Math::polar2rectangular(6, 2*Math::PI);
print "Polar coord [6, 2pi] to Rectangular\n";
var_dump($rect);
unset($rect);
?>

<?php
$rect = Math::polar2rectangular(4, 6.26);
print "Polar coord [4, 6.26] to Rectangular\n";
var_dump($rect);
unset($rect);
?>

<?php
$rect = Math::polar2rectangular(4.2426, -Math::PI/2);
print "Polar coord [4.2426, -pi/2] to Rectangular\n";
var_dump($rect);
unset($rect);
?>

<?php
$rect = Math::polar2rectangular(4.2426, Math::PI/4);
print "Polar coord [4.2426, pi/4] to Rectangular\n";
var_dump($rect);
unset($rect);
?>

<?php
$x = new Scalar(-12.6);
$z = Math::abs($x);
print "{$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Scalar(-12.6);
$y = new Imaginary(31.792);
$z = $x->add($y);
print "{$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Scalar(2);
$z = Math::pow($x, 2);
print "{$x}^2 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = -9;
$z = Math::pow($x, -2);
print "{$x}^-2 = {$z}\n";
print "Lets restore: ".($z*Math::pow($x, 3))."\n";
print("Type of z is ".Delegator::getType($z)."\n");
unset($x, $z);
?>

<?php
$x = new Imaginary(1);
$z = Math::pow($x, 2);
print "{$x}^2 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Imaginary(1);
$z = Math::pow($x, 3);
print "{$x}^3 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Imaginary(1);
$z = Math::pow($x, 4);
print "{$x}^4 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Imaginary(1);
$z = Math::pow($x, 0);
print "{$x}^0 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Imaginary(-3);
$z = Math::pow($x, 3);
print "{$x}^3 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Imaginary(2);
$z = Math::pow($x, -2);
print "{$x}^-2 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);

Utils::test(
	fn: function() {
		return Math::pow(new Imaginary(2), -2);
	},
	check: function($res, $err) {
		return ("$res"=="-0.25");
	},
	descr: 'Math::pow(new Imaginary(2), -2)===-0.25'
);
?>

<?php
$x = new Imaginary(2);
$z = Math::pow($x, -3);
print "{$x}^-3 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);

Utils::test(
	fn: function() {
		return Math::pow(new Imaginary(2), -3);
	},
	check: function($res, $err) {
		return ("$res"=="0.125i");
	},
	descr: 'Math::pow(new Imaginary(2), -3)===0.125i'
);
?>

<?php
$x = new Imaginary(2);
$z = Math::pow($x, -4);
print "{$x}^-4 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);

Utils::test(
	fn: function() {
		return Math::pow(new Imaginary(2), -4);
	},
	check: function($res, $err) {
		return ("$res"=="0.0625");
	},
	descr: 'Math::pow(new Imaginary(2), -4)===0.0625'
);
?>

<?php
$x = new Imaginary(2);
$z = Math::pow($x, -5);
print "{$x}^-5 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);

Utils::test(
	fn: function() {
		return Math::pow(new Imaginary(2), -5);
	},
	check: function($res, $err) {
		return ("$res"=="-0.03125i");
	},
	descr: 'Math::pow(new Imaginary(2), -5)===-0.03125i'
);
?>

<?php
$x = Math::avg(2937485895, 5e12, 15e11, 1e-15, 66666666666);
print "Math::avg(2937485895, 5e12, 15e11, 1e-15, 66666666666) is {$x}\n";
$y = 1313920830512.202;
$check_x = Math::compare($x, '=', $y);
print var_export($check_x, 1)." = Math::compare($x, '=', $y); \n";
?>

<?php
$x = Math::avg(5e-17, 37e-19, 69e-21, 999e-23, 8943e-25);
print "Math::avg(5e-17, 37e-19, 69e-21, 999e-23, 8943e-25) is {$x}\n";
// $y = 1.075597686e-17;
$y = 7e-20;
$check_x = Math::compare($x, '=', $y);
print var_export($check_x, 1)." = Math::compare($x, '=', $y); \n";
$y = 1.07559768600001e-17;
$check_x = Math::compare($x, '=', $y);
print var_export($check_x, 1)." = Math::compare($x, '=', $y); \n";
?>

Utils\R tests

<?php
Utils::test(
	fn: function() {
		return (R::fromArray([5,6,7,8,9]))->splice(2, 1, [6.5, 6.9, 7.2, 7.7]);
	},
	check: function($res, $err) {
		return ("$res"=="[5, 6, 6.5, 6.9, 7.2, 7.7, 8, 9]");
	},
	descr: '(R::fromArray([5,6,7,8,9]))->splice(2, 1, [6.5, 6.9, 7.2, 7.7])'
);
?>

<?php
Utils::test(
	fn: function() {
		$a = (R::fromArray([1,2,3,4,5,6]))->slice(2);
		$b = (R::fromArray([1,2,3,4,5,6]))->shift(2);
		print "$a == $b \n";
		return $a->isEqual($b);
	},
	check: true,
	descr: '$a->slice(2)==$b->shift(2)'
);
?>
</pre>
