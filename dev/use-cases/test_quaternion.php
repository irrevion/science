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
?>

<?php
$Q = new Quaternion(new Scalar(-5.75));
print "-5.75 -> $Q (".($Q::class).")\n";
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
</pre>