<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/Math/Operations/Delegator.php");
require_once("../vendor/irrevion/science/Math/Entities/Entity.php");
require_once("../vendor/irrevion/science/Math/Entities/Scalar.php");
require_once("../vendor/irrevion/science/Math/Entities/Imaginary.php");
require_once("../vendor/irrevion/science/Math/Entities/Complex.php");

use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Entities\Imaginary;
?>

<pre>
<?php
$n = new Scalar(5);
print("Scalar to string is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);
?>

<?php
$x = new Scalar(9);
$x = $x->invert();
print("Inverted x is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new Scalar(5);
$y = new Scalar(3);
$z = $x->multiply($y);
print("{$x} * {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Scalar(5);
$y = -23.13e-2;
$z = $x->multiply($y);
print("{$x} * {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Scalar(20);
$y = 5;
$z = $x->divide($y);
print("{$x} / {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Scalar(14);
$y = new Scalar(88);
$z = $x->add($y);
print("{$x} + {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Scalar(2263);
$y = new Scalar(3751);
$z = $x->subtract($y);
print("{$x} - {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Scalar(12);
$y = new Imaginary(3751);
$z = $x->multiply($y);
print("{$x} * {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>
</pre>
