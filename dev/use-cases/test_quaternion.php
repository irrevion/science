<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Helpers\Utils;
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
$R = new Scalar(777.3);
$j277d3 = new QuaternionComponent(277.3, 'j');
$Q = $R->subtract($j277d3);
print "$R - $j277d3 = $Q ".($Q::class)." \n";
print "\n ".memory_get_usage()." memory used \n\n";
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

print "\n ".memory_get_usage()." memory used \n\n";
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
$z = (new Scalar(12))->divide(new QuaternionComponent(6, 'j'));
print "reference is [0.000 +0.000i -2.000j +0.000k], result obtained is $z \n";
print "\n ".memory_get_usage()." memory used \n\n";
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
print "\n ".memory_get_usage()." memory used \n\n";
?>

<?php
$Qx = new Quaternion([0, 1, 0, 0]);
$Qy = new Quaternion([0, 0, 1, 0]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
print "\n ".memory_get_usage()." memory used \n\n";

$Qx = new Quaternion([0, 0, 1, 0]);
$Qy = new Quaternion([0, 1, 0, 0]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
print "\n ".memory_get_usage()." memory used \n\n";

$Qx = new Quaternion([0, 0, 0, 1]);
$Qy = new Quaternion([0, 0, 0, 1]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
print "\n ".memory_get_usage()." memory used \n\n";

$Qz = (new Quaternion([0, 1, 0, 0]))->multiply(new Quaternion([0, 0, 1, 0]))->multiply(new Quaternion([0, 0, 0, 1]));
print "ijk = $Qz (".($Q::class).")\n";
print "\n ".memory_get_usage()." memory used \n\n";

$Qx = new Quaternion([3, 0, 0, 0]);
$Qy = new Quaternion([5, 0, 0, 0]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
print "\n ".memory_get_usage()." memory used \n\n";

$Qx = new Quaternion([3, 0, 0, 0]);
$Qy = new Quaternion([0, 5, 7, 9]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
print "\n ".memory_get_usage()." memory used \n\n";

$Qx = new Quaternion([0, 3, -2, 4]);
$Qy = new Quaternion([0, 5, 7, 9]);
$Qz = $Qx->multiply($Qy);
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
print "\n ".memory_get_usage()." memory used \n\n";

$Qx = new Quaternion([4.1, 8.2, 16.4, 32.8]);
$Qy = new Quaternion([-0.2, 7.843, 194.34, 9999.9999]);
$Qz = $Qx->multiply($Qy, 'ALGEBRAIC');
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
$Qz = $Qx->multiply($Qy, 'GEOMETRIC');
print "$Qx * $Qy = $Qz (".($Q::class).")\n";
print "reference is -331252.305 +157656.163i -80949.235j +42458.402k ( dev/ref/quaternion.py )\n";
print "\n ".memory_get_usage()." memory used \n\n";

print "abs is ".$Qz->abs(1, 1)."===".$Qz->abs(1, 0)." ( ".($Qz::class)." ) \n";
print "reference is 378072.8103811085 ( dev/ref/quaternion.py )\n";
print "\n ".memory_get_usage()." memory used \n\n";

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
print "\n ".memory_get_usage()." memory used \n\n";

//$Qx = Math::pow(new Quaternion([1, 0, 0, 0]), 2);
//print "[1, 0, 0, 0]**2 is $Qx \n";
//$Qx = Math::pow(new Quaternion([0, 1, 0, 0]), 2);
//print "[0, 1, 0, 0]**2 is $Qx \n";
//$Qx = Math::pow(new Quaternion([0, 0, 1, 0]), 2);
//print "[0, 0, 1, 0]**2 is $Qx \n";
//$Qx = Math::pow(new Quaternion([0, 0, 0, 1]), 2);
//print "[0, 0, 0, 1]**2 is $Qx \n";
//$Qx = Math::pow(new Quaternion([0, 0, 0, 1]), 3);
//print "[0, 0, 0, 1]**3 is $Qx \n";

// $Qx = (new Quaternion([0.97, -1.001, 0, 1]))->methodPowNaturalMultiply(999);
// print "[0.97, -1.001, 0, 1]**999 is $Qx \n";
// print "\n ".memory_get_usage()." memory used \n\n";
Utils::test(
	fn: function() {
		return (new Quaternion([0.97, -1.001, 0, 1]))->methodPowNaturalMultiply(999);
	},
	check: '[4.4425991155259E+233 + -9.5696657389331E+233i + 3.6403304936473E+219j + 9.5601056332997E+233k]',
	descr: '[0.97, -1.001, 0, 1]**999'
);
//print "ref py: 444259911552597290066118628614398031383945731561846574354735107382326975543213166346188440998186669164510536582655416006370417677592798055653753554160818071525184451915646025900536178909266048603067922169229232418408837762345057910784.000 -956966573893243930061434308203265967692690648180075647922908410998464995139259716751279288330591013071392977891309396764157709375697924166401700677768274843404492057716760390413229804166204670198096123458328671698714899040590641496064.000i +0.000j +956010563329913952568551685582789496840900797778170551965479914423547142620096176164503601602022742446782972526108356562393342321986015143484037158346132389417629936823649346373943802003088868445429063309190107806367942823989718548480.000k\n\n";
//$Qx = Math::pow(new Quaternion([0, 1, 0, 1]), 2);
//print "[0, 1, 0, 1]**2 is $Qx \n";
//$Qx = Math::pow(new Quaternion([0, 1, 2, 1]), 2);
//print "[0, 1, 2, 1]**2 is $Qx \n";
//$Qx = Math::pow(new Quaternion([0, 2, 3, 5]), 2);
//print "[0, 2, 3, 5]**2 is $Qx \n";
//$Qx = Math::pow(new Quaternion([10, 2, 3, 5]), 2);
//print "[10, 2, 3, 5]**2 is $Qx \n";
//$Qx = Math::pow(new Quaternion([10, 2, 3, 5]), 3);
//print "[10, 2, 3, 5]**3 is $Qx \n";
//$Qx = Math::pow(new Quaternion([2.4, 4.81, 9.621, 19.2431]), 2);
//print "[2.4, 4.81, 9.621, 19.2431]**2 is $Qx \n";
//$Qx = Math::pow(new Quaternion([2.4, 4.81, 9.621, 19.2431]), 3);
//print "[2.4, 4.81, 9.621, 19.2431]**3 is $Qx \n";
//$Qx = Math::pow(new Quaternion([2.4, 4.81, 9.621, 19.2431]), 1/2);
//print "[2.4, 4.81, 9.621, 19.2431]**1/2 is $Qx (ref: 3.505 +0.686i +1.372j +2.745k) \n";
//$Qx = Math::pow(new Quaternion([2.4, 4.81, 9.621, 19.2431]), 2/3);
//print "[2.4, 4.81, 9.621, 19.2431]**2/3 is $Qx (ref: 4.430 +1.425i +2.851j +5.702k) \n";
//$Qx = Math::pow(new Quaternion([2.4, 4.81, 9.621, 19.2431]), new Fraction('9/10'));
//print "[2.4, 4.81, 9.621, 19.2431]**0.9 is $Qx (ref: 4.098 +3.435i +6.870j +13.741k) \n";
//$Qx = Math::pow(new Quaternion([2.4, 4.81, 9.621, 19.2431]), -5);
//print "[2.4, 4.81, 9.621, 19.2431]**-5 is $Qx \n";
//$Qx = Math::pow(new Quaternion([0.00067225, 0.03, -5.21e-7, 1e-35]), -5);
//print "[0.00067225, 0.03, -5.21e-7, 1e-35]**-5 is $Qx (ref: 4594590.884 -40843029.678i +709.307j -0.000k) \n";

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

<?php
$Qx = new Quaternion([3, 7, 11, 19]);
$Qr = $Qx->reciprocal();
print "$Qx reciprocal is $Qr ( ".($Qr::class)." ) \n";
print "ref is [0.006 -0.013i -0.020j -0.035k] \n";

$Qx = new Quaternion([3, 7, 11, 19]);
$Qy = new Quaternion([2, 4, 8, 16]);
$Qz = $Qx->divide($Qy);
print "$Qx / $Qy = $Qz ( ".($Qz::class)." ) \n";
print "ref is [1.253 -0.065i +0.100j -0.065k] \n";

print "\n ".memory_get_usage()." memory used \n\n";
?>

<?php
$Qx = new Quaternion([3, 0, 11, 0]);
$Qy = new Quaternion([2, 0, 8, 16]);
$Qz = $Qx->add($Qy);
print "$Qx + $Qy = $Qz ( ".($Qz::class)." ) \n";
$Qx = new Quaternion([0, 0, 0, 0]);
$Qy = new Quaternion([1, -5, 332.56, -9431.4739]);
$Qz = $Qx->subtract($Qy);
print "$Qx + $Qy = $Qz ( ".($Qz::class)." ) \n";
$Qx = new Quaternion([3, 0, 11, 0]);
$Cy = new Complex(2, 15);
$Qz = $Qx->subtract($Cy);
print "$Qx + $Cy = $Qz ( ".($Qz::class)." ) \n";

print "\n ".memory_get_usage()." memory used \n\n";
?>
</pre>