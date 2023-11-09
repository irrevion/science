<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/Math/Branches/BaseMath.php");
require_once("../vendor/irrevion/science/Math/Math.php");
require_once("../vendor/irrevion/science/Math/Operations/Delegator.php");
require_once("../vendor/irrevion/science/Math/Entities/Entity.php");
require_once("../vendor/irrevion/science/Math/Entities/Scalar.php");
require_once("../vendor/irrevion/science/Math/Entities/Imaginary.php");
require_once("../vendor/irrevion/science/Math/Entities/Complex.php");
require_once("../vendor/irrevion/science/Math/Entities/ComplexPolar.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Entities\Imaginary;
use irrevion\science\Math\Entities\Complex;
use irrevion\science\Math\Entities\ComplexPolar;
?>

<pre>
<?php
$x = new ComplexPolar(4.27, Math::PI/4);
print("ComplexPolar(4.27, Math::PI/4) to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new ComplexPolar(5.13, Math::PI/2);
print("ComplexPolar(5.13, Math::PI/2) to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new ComplexPolar(-5.13, -Math::PI/2);
print("ComplexPolar(-5.13, -Math::PI/2) to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new ComplexPolar(6.03, Math::PI*3/4);
print("ComplexPolar(6.03, Math::PI*3/4) to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new ComplexPolar(7.89, Math::PI);
print("ComplexPolar(7.89, Math::PI) to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new ComplexPolar(9, -Math::PI);
print("ComplexPolar(9, -Math::PI) to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new ComplexPolar(9, 0);
print("ComplexPolar(9, 0) to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new ComplexPolar(11.5, Math::PI*5/4);
print("ComplexPolar(11.5, Math::PI*5/4) to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new ComplexPolar(27, Math::PI*27/4);
print("ComplexPolar(27, Math::PI*27/4) to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new Complex(-4.949747468306, 4.949747468306);
$y = $x->toPolar();
print("{$x} ".($x::class)." became {$y} ".($y::class)."\n");
unset($x, $y);
?>

<?php
$x = new Complex(3, 2);
$y = new Complex(-4, 9);
$z = $x->add($y);
print "$x + $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->add($b);
print "$a + $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i + $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(12, 9);
$y = new Complex(-12, -6);
$z = $x->add($y);
print "$x + $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->add($b);
print "$a + $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i + $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(21, 11);
$y = new Complex(-2, -57);
$z = $x->add($y);
print "$x + $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->add($b);
print "$a + $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i + $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(-2, -57);
$y = new Complex(21, 11);
$z = $x->add($y);
print "$x + $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->add($b);
print "$a + $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i + $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(-203, 12);
$y = new Complex(9, 91);
$z = $x->add($y);
print "$x + $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->add($b);
print "$a + $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i + $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(-8536.9999, -12743.46382);
$y = new Complex(8536.9635, 12743.463956);
$z = $x->add($y);
print "$x + $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->add($b);
print "$a + $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i + $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(2, -2);
$y = new Complex(-2, +2);
$z = $x->add($y);
print "$x + $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->add($b);
print "$a + $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i + $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(2, -2);
$y = new Complex(2, -2);
$z = $x->subtract($y);
print "$x - $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->subtract($b);
print "$a - $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i - $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(33, 21);
$y = new Complex(31, 23);
$z = $x->subtract($y);
print "$x - $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->subtract($b);
print "$a - $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i - $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(1024.553, 12);
$y = new Complex(-9975.447, 12);
$z = $x->subtract($y);
print "$x - $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->subtract($b);
print "$a - $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i - $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(3, 3);
$y = new Complex(10, 1);
$z = $x->multiply($y);
print "$x * $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->multiply($b);
print "$a * $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i * $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(-5, -14);
$y = new Complex(3, -3);
$z = $x->multiply($y);
print "$x * $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->multiply($b);
print "$a * $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i * $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(91845, -1.4);
$y = new Complex(324783, -13.3894);
$z = $x->multiply($y);
print "$x * $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->multiply($b);
print "$a * $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i * $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(3, 3);
$y = new Complex(10, 1);
$z = $x->divide($y);
print "$x / $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->divide($b);
print "$a / $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i / $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(27, 33);
$y = new Complex(10, 1);
$z = $x->divide($y);
print "$x / $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->divide($b);
print "$a / $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i / $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(0, 1);
$y = new Complex(-1, 0);
$z = $x->divide($y);
print "$x / $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->divide($b);
print "$a / $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i / $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(5, 12);
$y = new Complex(-5, -12);
$z = $x->divide($y);
print "$x / $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->divide($b);
print "$a / $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i / $j = $k (".$c::class.")\n";
?>

<?php
$x = new Complex(5, 12);
$y = new Complex(5, 12);
$z = $x->divide($y);
print "$x / $y = $z (".$z::class.")\n";
$a = $x->toPolar();
$b = $y->toPolar();
$c = $a->divide($b);
print "$a / $b = $c (".$c::class.")\n";
$i = $a->toRectangular();
$j = $b->toRectangular();
$k = $c->toRectangular();
print "Restored as: $i / $j = $k (".$c::class.")\n";
?>
</pre>
