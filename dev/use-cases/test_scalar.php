<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

$mem = memory_get_usage();
print "$mem memory used \n";

require_once("../autoloader.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex, Vector};

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
$mem = memory_get_usage();
print "\n $mem memory used \n\n";
?>

<?php
$x = new Scalar(12);
$y = new Imaginary(3751);
$z = $x->multiply($y);
print("{$x} * {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
$mem = memory_get_usage();
print "\n $mem memory used \n\n";
?>

<?php
$x = new Scalar(25);
$z = Math::pow($x, 2);
print "{$x}**2 is {$z} ( ".($z::class)." ) \n";
print "ref: 625 \n"; // ref/scalar.py
$mem = memory_get_usage();
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
$mem = memory_get_usage();
print "\n $mem memory used \n\n";

$x = new Scalar(-1.678903);
$z = Math::pow($x, new Scalar(-2.5));
print "{$x}**-2.5 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".((-1.678903)**-2.5)." \n"; // Houston, we have a problem
print "ref py: (8.382756431709652e-17-0.2738016034515765j) \n";
$mem = memory_get_usage();
print "\n $mem memory used \n\n";

$x = new Scalar(1.678903);
$z = Math::pow($x, new Scalar(-2.5));
print "{$x}**-2.5 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".((1.678903)**-2.5)." \n"; // no problem here
print "ref py: (8.382756431709652e-17-0.2738016034515765j) \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(125);
$y = new Fraction('1/3');
$z = Math::pow($x, $y);
print "{$x}**{$y} is {$z} ( ".($z::class)." ) \n";
print "ref: 25 \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(625);
$z = Math::pow($x, new Scalar(0.2));
print "{$x}**0.2 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".(625**0.2)." \n";
print "ref py: 3.623898318388478 \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(625);
$z = Math::pow($x, new Fraction('1/5'));
print "{$x}**1/5 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".(625**0.2)." \n";
print "ref py: 3.623898318388478 \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(-625);
$z = Math::pow($x, new Scalar(0.2));
print "{$x}**0.2 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".((-625)**0.2)." \n";
print "ref py: (2.9317953254630726+2.1300739873562407j) \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(-625);
$z = Math::pow($x, new Fraction('1/5'));
print "{$x}**1/5 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".((-625)**0.2)." \n";
print "ref py: (2.9317953254630726+2.1300739873562407j) \n";
print "check: $z ** 5 = ".Math::pow($z, new Scalar(5))." \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(-3.6238983183885);
$z = Math::pow($x, new Fraction('-1/5'));
print "{$x}**-1/5 is {$z} ( ".($z::class)." ) \n";
print "ref php: ".((-625)**-0.2)." \n";
print "ref self: ".(1 / Math::pow($x, new Fraction('1/5'))->toNumber())." \n";
print "ref py: (0.6253489772392994-0.4543426268090075j) \n";
print "ref calc: -0.38073079 \n";
print "ref online: -0.77297384554805 \n";
print "ref self complex: ".print((new Vector((new Complex($x))->roots(5), null))->map(fn($v) => $v->reciprocal()."", ''))." \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(-1);
$z = Math::pow($x, new Fraction('-1/2'));
print "{$x}**-1/2 is {$z} ( ".($z::class)." ) \n";
print "ref: i \n";
print "ref py: (6.123233995736766e-17-1j) \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(0);
$z = Math::pow($x, $x);
print "{$x}**0 is {$z} ( ".($z::class)." ) \n";
print "ref: 1 \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(-1);
$z = Math::pow($x, 23);
print "{$x}**23 is {$z} ( ".($z::class)." ) \n";
print "ref: -1 \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(-1);
$z = Math::pow($x, 24);
print "{$x}**24 is {$z} ( ".($z::class)." ) \n";
print "ref: 1 \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(Math::E);
$z = Math::pow($x, new Imaginary(Math::PI));
print "{$x}**πi is {$z} ( ".($z::class)." ) \n";
print "ref: -1 \n";
print "ref py: (-1+1.2246467991473532e-16j) \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(1);
$z = Math::pow($x, new Imaginary(1));
print "{$x}**i is {$z} ( ".($z::class)." ) \n";
print "ref py: (1+0j) \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(1);
$z = Math::pow($x, new Imaginary(0.5));
print "{$x}**0.5i is {$z} ( ".($z::class)." ) \n";
print "ref py: (1+0j) \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(4);
$z = Math::pow($x, new Imaginary(2));
print "{$x}**2i is {$z} ( ".($z::class)." ) \n";
print "ref py: (-0.9326870768360711+0.360686590689181j) \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(4);
$z = Math::pow($x, new Complex(2, 2));
print "{$x}**(2+2i) is {$z} ( ".($z::class)." ) \n";
print "ref py: (-14.922993229377138+5.770985451026896j) \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = new Scalar(4);
$z = Math::pow($x, new Complex(2.5, 2));
print "{$x}**(2.5+2i) is {$z} ( ".($z::class)." ) \n";
print "ref py: (-29.845986458754275+11.541970902053793j) \n";
print "\n ".memory_get_usage()." memory used \n\n";

$x = Math::factorial(5);
print "5! is {$x} \n";
$x = Math::factorial(10);
print "10! is {$x} \n";
$x = Math::factorial(7.993);
print "8! is {$x} \n";
$x = Math::factorial(8.12);
print "8! is {$x} \n";
$x = Math::factorial(77);
print "77! is {$x} \n";
print "\n ".memory_get_usage()." memory used \n\n";
$x = Math::factorial(777);
var_dump($x);

$x = Math::factorial(new Scalar(5));
print "5! is {$x} \n";
$x = Math::factorial(new Scalar(10));
print "10! is {$x} \n";
$x = Math::factorial(new Scalar(7.993));
print "8.! is {$x} \n";
$x = Math::factorial(new Scalar(8.12));
print "8.! is {$x} \n";
$x = Math::factorial(new Scalar(77));
print "77! is {$x} \n";
print "\n ".memory_get_usage()." memory used \n\n";

?>
</pre>
