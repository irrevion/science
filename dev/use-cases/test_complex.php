<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\{Scalar, Imaginary, Complex};
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
</pre>
