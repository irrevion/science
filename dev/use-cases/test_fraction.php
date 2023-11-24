<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/autoloader.php");

use irrevion\science\Math\Entities\{Scalar, Fraction};
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
?>
</pre>