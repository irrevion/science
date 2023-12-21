<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

$mem = memory_get_usage();
print "$mem memory used \n";

require_once("../autoloader.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary};

$mem = memory_get_usage();
print "$mem memory used \n";
?>

<pre>
<?php
$n = new Scalar(5);
print("Scalar to string is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);

$mem = memory_get_usage();
print "\n $mem memory used \n\n";
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
print "\n $mem memory used \n\n";
?>

<?php
$x = new Scalar(12);
$y = new Imaginary(3751);
$z = $x->multiply($y);
print("{$x} * {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
print "\n $mem memory used \n\n";
?>

<?php
$x = new Scalar(25);
$z = Math::pow($x, 2);
print "{$x}**2 is {$z} ( ".($z::class)." ) \n";
print "ref: 625 \n"; // ref/scalar.py
print "\n $mem memory used \n\n";

$x = new Scalar(25);
$z = Math::pow($x, -2);
print "{$x}**-2 is {$z} ( ".($z::class)." ) \n";
print "ref: 0.0016 \n";

$x = new Scalar(-1.678903);
$z = Math::pow($x, -2);
print "{$x}**-2 is {$z} ( ".($z::class)." ) \n";
print "ref: ".((-1.678903)**-2)." \n";
print "ref: 0.35477155351092565 \n";

$x = new Scalar(-1.678903);
$z = Math::pow($x, new Scalar(-2));
print "{$x}**-2 is {$z} ( ".($z::class)." ) \n";
print "ref: 0.35477155351092565 \n";
print "\n $mem memory used \n\n";

$x = new Scalar(-1.678903);
$z = Math::pow($x, new Scalar(-2.5));
print "{$x}**-2.5 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".((-1.678903)**-2.5)." \n"; // Houston, we have a problem
print "ref py: (8.382756431709652e-17-0.2738016034515765j) \n";
print "\n $mem memory used \n\n";

$x = new Scalar(1.678903);
$z = Math::pow($x, new Scalar(-2.5));
print "{$x}**-2.5 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".((1.678903)**-2.5)." \n"; // no problem here
print "ref py: (8.382756431709652e-17-0.2738016034515765j) \n";
print "\n $mem memory used \n\n";

$x = new Scalar(625);
$z = Math::pow($x, new Scalar(0.2));
print "{$x}**0.2 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".(625**0.2)." \n";
print "ref py: 3.623898318388478 \n";
print "\n $mem memory used \n\n";

$x = new Scalar(625);
$z = Math::pow($x, new Fraction('1/5'));
print "{$x}**1/5 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".(625**0.2)." \n";
print "ref py: 3.623898318388478 \n";
print "\n $mem memory used \n\n";

$x = new Scalar(-625);
$z = Math::pow($x, new Scalar(0.2));
print "{$x}**0.2 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".((-625)**0.2)." \n";
print "ref py: (2.9317953254630726+2.1300739873562407j) \n";
print "\n $mem memory used \n\n";

$x = new Scalar(-625);
$z = Math::pow($x, new Fraction('1/5'));
print "{$x}**1/5 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".((-625)**0.2)." \n";
print "ref py: (2.9317953254630726+2.1300739873562407j) \n";
print "check: $z ** 5 = ".Math::pow($z, new Scalar(5))." \n";
print "\n $mem memory used \n\n";
?>
</pre>
