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
$z = $x->divide($y);
print "$x / $y = $z (".$z::class.")\n";
$rz = $y->reciprocal();
$w = $x->multiply($rz);
print "$x * $rz = $w (".$w::class.")\n";
?>

<?php
$x = new Vector([4,4]);
$y = new Vector([2,1]);
$z = $x->dotProduct($y);
print "$x ∙ $y = $z (".$z::class.")\n";
$w = $x->dotT($y);
print "{$x}ᵀ ∙ $y = $w (".$w::class.")\n";
?>

<?php
$x = new Vector([-3, 15]);
$y = new Vector([5, 0.3]);
$z = $x->dotProduct($y);
print "$x ∙ $y = $z (".$z::class.")\n";
$w = $x->dotT($y);
print "{$x}ᵀ ∙ $y = $w (".$w::class.")\n";
?>

<?php
$x = new Vector([2, 3], 'irrevion\science\Math\Entities\Imaginary');
$y = new Vector([-4, -5], 'irrevion\science\Math\Entities\Imaginary');
$z = $x->dotProduct($y);
print "$x ∙ $y = $z (".$z::class.")\n";
$w = $x->dotT($y);
print "{$x}ᵀ ∙ $y = $w (".$w::class.")\n";
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
$w = $x->dotT($y);
print "{$x}ᵀ ∙ $y = $w (".$w::class.")\n";
?>

<?php
$x = new Vector([347, 9821, 2093456, 0.001, -32, 1, 100.78, 4]);
$y = new Vector([9, 43, 2, 999999, 1, 17.3, 821.004583, 2]);
$z = $x->dot($y);
print "$x ∙ $y = $z (".$z::class.")\n";
$w = $x->dotT($y);
print "{$x}ᵀ ∙ $y = $w (".$w::class.")\n";
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
print "$z * $y = $x (type ".$z::class." of {$z->inner_type})\n";
$x = $x->invert();
print "$x\n";
?>

<?php
//$x = new Vector([3, 99999999]);
//$y = $x->transpose();
//print "{$x}ᵀ is $y (type ".$y::class." of {$y->inner_type})\n";
//$z = $z->conjugate($x);
//print "$x* is $z (type ".$z::class." of {$z->inner_type})\n";
//$w = (new Vector([23, 17.5, -551]))->conjugate();
//print "w is $w (type ".$w::class." of {$w->inner_type})\n";
?>

<?php
$x = new Vector([3, 1]);
$y = new Vector([-1, 3]);
$z = $x->isOrthogonal($y);
print "{$x} is".($z? '': ' not')." orthogonal to {$y}\n";
$x = new Vector([3, 4, 0]);
$y = new Vector([-4, 3, 2]);
$z = $x->isOrthogonal($y);
print "{$x} is".($z? '': ' not')." orthogonal to {$y}\n";
$w = $x->dot($y);
print "dot() = $w\n";
?>

<?php
$x = new Vector([3, 1]);
$y = new Vector([-1, 3]);
$cl1 = $x->isCollinear($y, 'DETERMINANT');
$cl2 = $x->isCollinear($y, 'DOT_PRODUCT');
$cl3 = $x->isCollinear($y, 'RATIO');
$cl4 = $x->isCollinear($y, 'NORM');
print "{$x} is collinear to {$y}? ".($cl1? 'yes': 'no')." / ".($cl2? 'yes': 'no')." / ".($cl3? 'yes': 'no')." / ".($cl4? 'yes': 'no')." \n";
$x = new Vector([1, 2, 3]);
$y = new Vector([2, 4, 6]);
$cl1 = $x->isCollinear($y, 'DETERMINANT');
$cl2 = $x->isCollinear($y, 'DOT_PRODUCT');
$cl3 = $x->isCollinear($y, 'RATIO');
$cl4 = $x->isCollinear($y, 'NORM');
print "{$x} is collinear to {$y}? ".($cl1? 'yes': 'no')." / ".($cl2? 'yes': 'no')." / ".($cl3? 'yes': 'no')." / ".($cl4? 'yes': 'no')." \n";
$x = new Vector([1, 2, 3]);
$y = new Vector([-2, -4, -6]);
$cl1 = $x->isCollinear($y, 'DETERMINANT');
$cl2 = $x->isCollinear($y, 'DOT_PRODUCT');
$cl3 = $x->isCollinear($y, 'RATIO');
$cl4 = $x->isCollinear($y, 'NORM');
print "{$x} is collinear to {$y}? ".($cl1? 'yes': 'no')." / ".($cl2? 'yes': 'no')." / ".($cl3? 'yes': 'no')." / ".($cl4? 'yes': 'no')." \n";
$x = new Vector([0, 0.02, 0.04, 0.06, 0]);
$y = new Vector([0, 2, 4, 6, 0]);
$cl1 = $x->isCollinear($y, 'DETERMINANT');
$cl2 = $x->isCollinear($y, 'DOT_PRODUCT');
$cl3 = $x->isCollinear($y, 'RATIO');
$cl4 = $x->isCollinear($y, 'NORM');
print "{$x} is collinear to {$y}? ".($cl1? 'yes': 'no')." / ".($cl2? 'yes': 'no')." / ".($cl3? 'yes': 'no')." / ".($cl4? 'yes': 'no')." \n";
?>

<?php
$x = new Vector([-2, -4, -6]);
$y = $x->conjugate();
print "{$x} conjugate is {$y} \n";
$z = $y->conjugate();
print "{$y} conjugate is {$z} \n";
?>

<?php
$x = new Vector([-2, -4, -6]);
$y = new Vector([5, 12, 43]);
$z = new Vector([88, 513, 29103]);
$w = $x->scalarTripleProduct($y, $z, 'DIRECT');
print "{$x} ∙ ( {$y} ⨯ {$z} ) = {$w} \n";
$w = $x->triple($y, $z, 'DETERMINANT');
print "{$x} ∙ ( {$y} ⨯ {$z} ) = {$w} (det) \n";
?>

<?php
$x = new Vector([-2, -4, -6]);
$y = new Vector([5, 12, 43]);
$z = new Vector([88, 513, 29103]);
$cpl = $x->isCoplanar($y, $z);
print "{$x}, {$y}, {$z} is".($cpl? '': ' not')." coplanar \n";
$x = new Vector([1,2,3]);
$y = new Vector([4,5,6]);
$z = new Vector([7,8,9]);
$cpl = $x->isCoplanar($y, $z);
print "{$x}, {$y}, {$z} is".($cpl? '': ' not')." coplanar \n";
?>
</pre>
