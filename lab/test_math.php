<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/Math/Branches/BaseMath.php");
require_once("../vendor/irrevion/science/Math/Operations/Delegator.php");
require_once("../vendor/irrevion/science/Math/Math.php");
require_once("../vendor/irrevion/science/Math/Entities/Entity.php");
require_once("../vendor/irrevion/science/Math/Entities/Scalar.php");
require_once("../vendor/irrevion/science/Math/Entities/Imaginary.php");
require_once("../vendor/irrevion/science/Math/Entities/Complex.php");

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Entities\Imaginary;
?>

<pre>
<?php
print Math::PI."\n";
print (Math::TAU / Math::PI)."\n";
print Math::E."\n";
print Math::abs(-3)."\n";
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

<?php /*
$x = new Imaginary(-3);
$z = Math::pow($x, 3);
print "{$x}^3 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Imaginary(2);
$z = Math::pow($x, -3);
print "{$x}^3 = {$z}\n";
print("Type of z is ".($z::class)."\n");
unset($x, $z);
*/ ?>
</pre>
