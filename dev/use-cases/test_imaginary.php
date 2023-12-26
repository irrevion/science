<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Helpers\Utils;
use irrevion\science\Math\Operations\Delegator;
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
$x = new Imaginary(5);
$y = new Imaginary(3);
$z = $x->add($y);
print "{$x} + {$y} is {$z} (".($z::class).") \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Imaginary(5);
$y = new Imaginary(3);
$z = $x->multiply($y);
print "{$x} * {$y} is {$z} (".($z::class).") \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
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
