<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Utils;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex, Vector};
?>

<pre>
<?php
$n = new Fraction(5);
print("new Fraction(5) is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);
?>

<?php
$n = new Fraction(5.75);
print("new Fraction(5.75) is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);
?>

<?php
$n = new Fraction("9/666");
print("new Fraction(9/666) is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);
?>

<?php
$n = new Fraction("57e4/94723526");
print("new Fraction(57e4/94723526) is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);
?>

<?php
try {
	$n = new Fraction(14.88e-15);
	print("new Fraction(14.88e-15) is {$n}\n");
	print("Type of n is ".($n::class)."\n");
	unset($n);
} catch (\Error $e) {
	print "Error: ".$e->getMessage()."\n";
}
?>

<?php
try {
	$n = new Fraction(-14.88e-15);
	print("new Fraction(-14.88e-15) is {$n}\n");
	print("Type of n is ".($n::class)."\n");
	unset($n);
} catch (\Error $e) {
	print "Error: ".$e->getMessage()."\n";
}
?>

<?php
try {
	$n = new Fraction(-14.88e-11);
	print("new Fraction(-14.88e-11) is {$n}\n");
	print("Type of n is ".($n::class)."\n");
	unset($n);
} catch (\Error $e) {
	print "Error: ".$e->getMessage()."\n";
}
?>

<?php
$x = new Fraction("2/3");
$y = new Fraction("3/4");
$z = $x->add($y);
print("{$x} + {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Fraction("2/3");
$y = new Fraction("3/4");
$z = $x->subtract($y);
print("{$x} - {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Fraction("-72/123");
$z = $x->negative();
print("-72/123 ( {$x} ) negative is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Fraction("15/-35");
$z = $x->negative();
print("15/-35 ( {$x} ) negative is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Fraction("-21/-77");
$z = $x->negative();
print("-21/-77 ( {$x} ) negative is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Fraction("22/-33");
$z = $x->reciprocal();
print("22/-33 ( {$x} ) reciprocal is {$z}\n");
$y = new Fraction("22/-33");
print("22/-33 ( {$y} )\n");
print("Type of z is ".($z::class)."\n");
unset($x, $z);
?>

<?php
$x = new Fraction("2/3");
$y = new Fraction("3/4");
$z = $x->multiply($y);
print("{$x} * {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Fraction("1/1000");
$y = new Fraction("1/-10000000");
$z = $x->multiply($y);
print("{$x} * {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Fraction("1/2");
$y = new Fraction("1/-4");
$z = $x->divide($y);
print("{$x} / {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
$x = new Fraction(0.75);
$y = new Fraction(0.125);
$z = $x->divide($y);
print("{$x} / {$y} is {$z} = ".$z->toNumber()."\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
print "\n ".memory_get_usage()." memory used \n\n";
?>

<?php
$x = new Fraction('3/4');
$y = new Fraction(0.125);
$z = Math::pow($x, $y);
print("{$x}**{$y} is {$z} ≅ ".$z->toNumber()." ( ".($z::class)." )\n");
print "ref py: 0.9646786299603094 \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Fraction('7/12');
$y = new Fraction('32/7');
$z = Math::pow($x, $y);
print("{$x}**{$y} is {$z} ≅ ".$z->toNumber()." ( ".($z::class)." )\n");
print "ref py: 0.08509525496083567 \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Fraction('43/42');
$y = new Fraction('9999/1');
$z = Math::pow($x, $y);
print("{$x}**{$y} is {$z} ≅ ".$z->toNumber()." ( ".($z::class)." )\n");
print "ref py: 1.5185624323363708e+102 \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Fraction(0.15);
$y = new Scalar(7.2);
$z = Math::pow($x, $y);
print("{$x}**{$y} is {$z} ≅ ".$z->toNumber()." ( ".($z::class)." )\n");
print "ref py: 1.1691145492539425e-06 \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Fraction('27/3');
$y = new Fraction('-2/4');
$z = Math::pow($x, $y);
print("{$x}**{$y} is {$z} ≅ ".$z->toNumber()." ( ".($z::class)." )\n");
print "ref py: 0.333 \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Fraction('-27/3');
$y = new Fraction('-2/4');
$z = Math::pow($x, $y);
print("{$x}**{$y} is {$z} ≅ ".$z->toNumber()." ( ".($z::class)." )\n");
print "ref py: (2.041077998578922e-17-0.3333333333333333j) \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Fraction('7/4');
$y = new Imaginary(-1);
$z = Math::pow($x, $y);
print("{$x}**{$y} is {$z} ≅ ".$z->toNumber()." ( ".($z::class)." )\n");
print "ref py: (0.8474591366187356-0.5308606330869028j) \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>

<?php
$x = new Fraction('7/4');
$y = new Complex(-1, 3.14);
$z = Math::pow($x, $y);
print("{$x}**{$y} is {$z} ≅ ".$z->toNumber()." ( ".($z::class)." )\n");
print "ref py: (-0.10589700489484924+0.5615304413824759j) \n";
print "\n ".memory_get_usage()." memory used \n\n";
unset($x, $y, $z);
?>
</pre>