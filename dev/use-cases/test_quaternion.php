<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex, ComplexPolar, Vector, QuaternionComponent, Quaternion};
?>

<pre>
- - - - - - - Quaternion component - - - - - - - -

<?php
$i = new QuaternionComponent(1);
$j = new QuaternionComponent(1, 'j');
$k = new QuaternionComponent(1, 'k');
$Q = $k->add($j);
print "$k + $j = $Q ".($Q::class)." \n";
$i6 = new QuaternionComponent(6, 'i');
$j13 = new QuaternionComponent(13, 'j');
$k27 = new QuaternionComponent(27, 'k');
$Q = $j13->add($i6->add($k27));
print "$j13 + $i6 + $k27 = $Q ".($Q::class)." \n";
$Q = $j13->add($i6)->add($k27);
print "$j13 + $i6 + $k27 = $Q ".($Q::class)." \n";
?>

<?php
$i = new QuaternionComponent(1);
print "$i type of ".($i::class)." \n";
$j = new QuaternionComponent(1, 'j');
print "$j type of ".($j::class)." \n";
$transforms_to = $i->rule($j->symbol);
print "$i x $j transforms into $transforms_to \n";
$k = $i->multiply($j);
print "$i x $j is $k (".($k::class).")\n";
$k2 = $k->multiply(new Scalar(2));
print "$k x 2 is $k2 (".($k2::class).")\n";
$j3 = new QuaternionComponent(3, 'j');
$minus_i6 = $k2->multiply($j3);
print "$k2 x $j3 is $minus_i6 (".($minus_i6::class).")\n";
$k03 = new QuaternionComponent(0.3, 'k');
$j1_8 = $minus_i6->multiply($k03);
print "$minus_i6 x $k03 is $j1_8 (".($j1_8::class).")\n";
$minus_a1_8 = $j1_8->multiply($j);
print "$j1_8 x $j is $minus_a1_8 (".($minus_a1_8::class).")\n";
$Q = $minus_a1_8->multiply($k);
print "$minus_a1_8 x $k is $Q (".($Q::class).")\n";
//var_export($Q->j());
//print "\n";
$j0 = $Q->j();
$j0 = $j0->multiply(new QuaternionComponent(-0.0, 'j'));
print "try to eliminate negative zero $j0 \n";

$Nj0 = (new QuaternionComponent(-0.0, 'j'))->toNumber();
print "to number ".var_export($Nj0, 1)." \n";
?>

<?php
$i = new QuaternionComponent(1, 'i');
$j = new QuaternionComponent(1, 'j');
$z = $i->divide($j);
print "reference is [0.000 +0.000i +0.000j -1.000k], result obtained is $z \n";
$z = $j->divide($i);
print "reference is [0.000 +0.000i +0.000j +1.000k], result obtained is $z \n";
$i = new QuaternionComponent(15, 'i');
$j = new QuaternionComponent(3, 'j');
$z = $i->divide($j);
print "reference is [0.000 +0.000i +0.000j -5.000k], result obtained is $z \n";
$z = $j->divide($i);
print "reference is [0.000 +0.000i +0.000j +0.200k], result obtained is $z \n";
$z = $j->divide(new Imaginary(15));
print "reference is [0.000 +0.000i +0.000j +0.200k], result obtained is $z \n";
$z = $i->divide(new Scalar(5));
print "reference is [0.000 +3.000i +0.000j +0.000k], result obtained is $z \n";
$k = new QuaternionComponent(0.03, 'k');
$j = new QuaternionComponent(89305.2, 'j');
$z = $k->divide($j);
print "reference is [0.000 +0.000i +0.000j +0.000k], result obtained is $z \n";
$z = $j->divide($k);
print "reference is [0.000 -2976840.000i +0.000j +0.000k], result obtained is $z \n";
//$z = (new Scalar(12))->divide(new QuaternionComponent(6, 'j'));
//print "reference is [?], result obtained is $z \n";
?>

- - - - - - - Quaternion - - - - - - - -

<?php
$Q = new Quaternion(new Scalar(-5.75));
print "-5.75 -> $Q (".($Q::class).")\n";
$Q = new Quaternion(new Scalar(-5.75), new Vector([7, 13, 17]));
print "[-5.75 + [7, 13, 17]] -> $Q (".($Q::class).")\n";
$Q = new Quaternion(new Imaginary(0));
print "0i -> $Q (".($Q::class).")\n";
$Q = new Quaternion(new Imaginary(-9.999999e-13));
print "-9.999999e-13i -> $Q (".($Q::class).")\n";
$Q = new Quaternion(new QuaternionComponent(Math::PI, 'k'));
print "πk -> $Q (".($Q::class).")\n";
$Q = new Quaternion(new Complex(7.21, -135.296));
print "[7.21 + -135.296i] -> $Q (".($Q::class).")\n";
$Q = new Quaternion(new ComplexPolar(26.3, 0.0974));
print "[r 26.3, φ 0.0974] -> $Q (".($Q::class).")\n";
$Q = new Quaternion(new ComplexPolar(26.3, (-Math::PI+0.0974)));
print "[r 26.3, φ -π+0.0974] -> $Q (".($Q::class).")\n";
$Q = new Quaternion(new Vector([
	new QuaternionComponent(-1, 'i'),
	new QuaternionComponent(17.3, 'j'),
	new QuaternionComponent(-2, 'k'),
], QuaternionComponent::class));
print "[-1i, 17.3j, -2k] -> $Q (".($Q::class).")\n";
$Q = new Quaternion($Q);
print "[-1i, 17.3j, -2k] -> $Q (".($Q::class).")\n";
$Q = new Quaternion([4.1, 8.2, 16.4, 32.8]);
print "[4.1, 8.2, 16.4, 32.8] -> $Q (".($Q::class).")\n";
?>

<?php
$Qx = new Quaternion([0, 1, 0, 0]);
$Qy = new Quaternion([0, 0, 1, 0]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
$Qx = new Quaternion([0, 0, 1, 0]);
$Qy = new Quaternion([0, 1, 0, 0]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
$Qx = new Quaternion([0, 0, 0, 1]);
$Qy = new Quaternion([0, 0, 0, 1]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
$Qz = (new Quaternion([0, 1, 0, 0]))->multiply(new Quaternion([0, 0, 1, 0]))->multiply(new Quaternion([0, 0, 0, 1]));
print "ijk = $Qz (".($Q::class).")\n";

$Qx = new Quaternion([3, 0, 0, 0]);
$Qy = new Quaternion([5, 0, 0, 0]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";

$Qx = new Quaternion([3, 0, 0, 0]);
$Qy = new Quaternion([0, 5, 7, 9]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";

$Qx = new Quaternion([0, 3, -2, 4]);
$Qy = new Quaternion([0, 5, 7, 9]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";

$Qx = new Quaternion([4.1, 8.2, 16.4, 32.8]);
$Qy = new Quaternion([-0.2, 7.843, 194.34, 9999.9999]);
$Qz = $Qx->multiply($Qy, 'ALGEBRAIC');
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
$Qz = $Qx->multiply($Qy, 'GEOMETRIC');
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
print "reference is -331252.305 +157656.163i -80949.235j +42458.402k ( dev/ref/quaternion.py )\n";
print "abs is ".$Qz->abs(1, 1)."===".$Qz->abs(1, 0)." ( ".($Qz::class)." ) \n";
print "reference is 378072.8103811085 ( dev/ref/quaternion.py )\n";

$Qx = new Quaternion([0.007, 0.00013, 0.0000214, 0.0000007935]);
$Qy = new Quaternion([0.008-0.001, 0.00012+0.00001, 0.0000214*1.0, 0.0000007936-0.0000000001]);
print "$Qx = $Qy? ".($Qx->isEqual($Qy)? 'yes': 'no')." \n";
print "$Qx ≈ $Qy? ".($Qx->isNear($Qy)? 'yes': 'no')." \n";
$Qx = new Quaternion([6897, 3419, 6793, 7401]);
$Qy = new Quaternion([6897, 3419, 6793, 7401]);
print "$Qx = $Qy? ".($Qx->isEqual($Qy)? 'yes': 'no')." \n";
print "$Qx ≈ $Qy? ".($Qx->isNear($Qy)? 'yes': 'no')." \n";
$Qx = new Quaternion([6897, 3419, 6793, 7401]);
$Qy = (new Quaternion([6897, 3419, 6793, 7401]))->multiply(1.0+1.3e-13);
print "$Qx = $Qy? ".($Qx->isEqual($Qy)? 'yes': 'no')." \n";
print "$Qx ≈ $Qy? ".($Qx->isNear($Qy)? 'yes': 'no')." \n";
$Qy = (new Quaternion([6897, 3419, 6793, 7401]))->multiply(1.0+1.3e-14);
print "$Qx ≈ $Qy? ".($Qx->isNear($Qy)? 'yes': 'no')." \n";

/*
$arr = [];
$start = microtime(true);
for ($i=0; $i<10000; $i++) {
	$x = new Quaternion([rand(1, 100), rand(1, 100), rand(1, 100), rand(1, 100)]);
	$y = new Quaternion([rand(1, 100), rand(1, 100), rand(1, 100), rand(1, 100)]);
	$arr[] = $x->multiply($y, 'GEOMETRIC'); // 1.6134839057922, 1.8237149715424, 1.6974439620972
}
$stop = microtime(true);
$t = $stop-$start;
print "geometric multiply ".count($arr)." quaternions performed in $t \n";
unset($arr);

$arr = [];
$start = microtime(true);
for ($i=0; $i<10000; $i++) {
	$x = new Quaternion([rand(1, 100), rand(1, 100), rand(1, 100), rand(1, 100)]);
	$y = new Quaternion([rand(1, 100), rand(1, 100), rand(1, 100), rand(1, 100)]);
	$arr[] = $x->multiply($y, 'ALGEBRAIC'); // 1.2235610485077, 1.0305309295654, 1.0823829174042
}
$stop = microtime(true);
$t = $stop-$start;
print "algebraic multiply ".count($arr)." quaternions performed in $t \n";
unset($arr);

$geom_avg = Math::avg(1.6134839057922, 1.8237149715424, 1.6974439620972);
$alg_avg = Math::avg(1.2235610485077, 1.0305309295654, 1.0823829174042);
$faster = $geom_avg / $alg_avg;
print "alg mul $alg_avg is $faster times faster than geom $geom_avg \n";
*/

/*
$arr = [];
$start = microtime(true);
for ($i=0; $i<50000; $i++) {
	$arr[] = (new Quaternion([rand(1, 100), rand(1, 100), rand(1, 100), rand(1, 100)]))->abs(individual: 0);
}
$stop = microtime(true);
$t = $stop-$start;
print "abs on ".count($arr)." quaternions performed in $t \n";
unset($arr);

$arr = [];
$start = microtime(true);
for ($i=0; $i<50000; $i++) {
	$arr[] = (new Quaternion([rand(1, 100), rand(1, 100), rand(1, 100), rand(1, 100)]))->abs(individual: 1);
}
$stop = microtime(true);
$t = $stop-$start;
print "abs on ".count($arr)." quaternions performed in $t \n";
unset($arr);
*/
?>
</pre>