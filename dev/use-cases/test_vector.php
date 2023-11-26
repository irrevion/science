<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex, ComplexPolar, Vector};
?>

<pre>
<?php
$x = new Vector([1,2,3,4,5]);
print("Vector([1,2,3,4,5]) to string is {$x}\n");
print("Type of x is ".($x::class)." of {$x->inner_type}\n");
unset($x);
?>

<?php
$x = new Vector([12, new Fraction("3/4"), new Imaginary(5), new Complex(21, 39), new ComplexPolar(15, Math::PI)], 'irrevion\science\Math\Entities\Complex');
print("new Vector([12, new Fraction(\"3/4\"), new Imaginary(5), new Complex(21, 39), new ComplexPolar(15, Math::PI)], 'irrevion\science\Math\Entities\Complex') to string is {$x}\n");
print("Type of x $x is ".($x::class)." of {$x->inner_type}\n");
$y = new Vector([7, 6, 5, 4, 3]);
$z = $x->multiply($y);
print("Type of z $z is ".($z::class)." of {$z->inner_type}\n");
$u = $z->multiply(new Imaginary(-1));
print("Type of u $u is ".($u::class)." of {$u->inner_type}\n");
unset($x);
?>

<?php /*
try {
	$x = new Vector('kapusta');
	print("Vector('kapusta') to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector('kapusta') -> ".$e->getMessage()."\n";
} */
?>

<?php /*
try {
	$x = new Vector(['k', 'a', 'p', 'u', 's', 't', 'a']);
	print("Vector(['k', 'a', 'p', 'u', 's', 't', 'a']) to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector(['k', 'a', 'p', 'u', 's', 't', 'a']) -> ".$e->getMessage()."\n";
} */
?>

<?php /*
try {
	$x = new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'string');
	print("Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'string') to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	var_dump($x->value);
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'string') -> ".$e->getMessage()."\n";
} */
?>

<?php /*
try {
	$x = new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'float');
	print("Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'float') to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	var_dump($x->value);
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'float') -> ".$e->getMessage()."\n";
} catch (\ReflectionException $e) {
	print "Error: new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'float') -> ".$e->getMessage()."\n";
} */
?>

<?php /*
try {
	$x = new Vector([73, 82, 995], 'irrevion\science\Math\Entities\Complex');
	print("Vector([73, 82, 995], 'irrevion\science\Math\Entities\Complex') to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	var_dump($x->value);
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector([73, 82, 995], 'irrevion\science\Math\Entities\Complex') -> ".$e->getMessage()."\n";
} catch (\ReflectionException $e) {
	print "Error: new Vector([73, 82, 995], 'irrevion\science\Math\Entities\Complex') -> ".$e->getMessage()."\n";
} */
?>

<?php
$x = new Vector([4,4]);
$y = new Vector([2,1]);
$z = $x->dotProduct($y);
print "$x ∙ $y = $z (".$z::class.")\n";
?>

<?php
$x = new Vector([-3, 15]);
$y = new Vector([5, 0.3]);
$z = $x->dotProduct($y);
print "$x ∙ $y = $z (".$z::class.")\n";
?>

<?php
$x = new Vector([2, 3], 'irrevion\science\Math\Entities\Imaginary');
$y = new Vector([-4, -5], 'irrevion\science\Math\Entities\Imaginary');
$z = $x->dotProduct($y);
print "$x ∙ $y = $z (".$z::class.")\n";
?>

<?php
$x = new Vector([
	['real' => 2, 'imaginary' => -4],
	['real' => 7, 'imaginary' => 5],
], 'irrevion\science\Math\Entities\Complex');
$y = new Vector([
	['real' => 1, 'imaginary' => 3],
	['real' => -2, 'imaginary' => 346.33],
], 'irrevion\science\Math\Entities\Complex');
$z = $x->dotProduct($y);
print "$x ∙ $y = $z (".$z::class.")\n";
?>

<?php
$x = new Vector([347, 9821, 2093456, 0.001, -32, 1, 100.78, 4]);
$y = new Vector([9, 43, 2, 999999, 1, 17.3, 821.004583, 2]);
$z = $x->dot($y);
print "$x ∙ $y = $z (".$z::class.")\n";
?>

<?php
$x = new Vector([1, 2, 3]);
$y = new Vector([4, 5, 6]);
$z = $x->multiply($y);
print "$x * $y = $z (type ".$z::class." of {$x->inner_type})\n";
$z = $z->divide($y);
print "/ $y = $z (type ".$z::class." of {$x->inner_type})\n";
?>

<?php
$x = new Vector([4, 3]);
$y = new Scalar(2);
$z = $x->multiply($y);
print "$x * $y = $z (type ".$z::class." of {$x->inner_type})\n";
?>

<?php
$x = new Vector([4, 3]);
$y = -2;
$z = $x->k($y);
print "$x * $y = $z (type ".$z::class." of {$x->inner_type})\n";
?>

<?php
$x = new Vector([4, 3, 0]);
$y = new Vector([5, 0, 0]);
$z = $x->multiply($y);
print "$x * $y = $z (type ".$z::class." of {$x->inner_type})\n";
?>

<?php
$x = new Vector([4, 3]);
$y = new Vector([5]);
$z = $x->multiply($y);
print "$x * $y = $z (type ".$z::class." of {$x->inner_type})\n";
?>

<?php
$x = new Vector([4, 3, 0]);
$y = new Vector([5, 0, 0]);
$z = $x->x($y);
print "$x ⨯ $y = $z (type ".$z::class." of {$x->inner_type})\n";
?>

<?php
$x = new Vector([4, 3]);
$y = new Vector([5, 0]);
$z = $x->vectorProduct($y);
print "$x ⨯ $y = $z (type ".$z::class." of {$x->inner_type})\n";
?>

<?php
$x = new Vector([-4, -3]);
$y = new Vector([-5, 0]);
$z = $x->vectorProduct($y);
print "$x ⨯ $y = $z (type ".$z::class." of {$x->inner_type})\n";
?>

<?php
$x = new Vector([-5, 0]);
$y = new Vector([-4, -3]);
$z = $x->vectorProduct($y);
print "$x ⨯ $y = $z (type ".$z::class." of {$x->inner_type})\n";
?>

<?php
$x = new Vector([23, 0, 0]);
$y = new Vector([3, 0, 0]);
$z = $x->vectorProduct($y);
print "$x ⨯ $y = $z (type ".$z::class." of {$z->inner_type})\n";
$z = $x->dot($y);
print "$x ∙ $y = $z (type ".$z::class.")\n";
$z = $x->multiplyElementwise($y);
print "$x * $y = $z (type ".$z::class." of {$z->inner_type})\n";
?>

<?php
$x = new Vector([4, 3, 0]);
$y = new Vector([0, 3, 4]);
$z = $x->vectorProduct($y);
print "$x ⨯ $y = $z (type ".$z::class." of {$z->inner_type})\n";
$z = $x->dot($y);
print "$x ∙ $y = $z (type ".$z::class.")\n";
$z = $x->multiplyElementwise($y);
print "$x * $y = $z (type ".$z::class." of {$z->inner_type})\n";
print $x->magnitude()." * ".$y->magnitude()." = ".$z->magnitude()." (type ".$z::class." of {$z->inner_type})\n";
?>

<?php
$x = new Vector([23, 17, -551]);
$y = $x->magnitude();
$z = $x->normalize();
print "$x / $y = $z (type ".$z::class." of {$x->inner_type})\n";
$x = $z->multiply($y);
print "$z * $y = $x (type ".$z::class." of {$x->inner_type})\n";
$x = $x->invert();
print "$x\n";
?>
</pre>
