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
</pre>