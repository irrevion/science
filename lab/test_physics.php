<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/autoloader.php");

use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Entities\Quantity;
use irrevion\science\Physics\Unit\{SI, CGS, IAU, Imperial, USC, NonStandard};
?>

<pre>
<?php
$x = new Quantity(23, 'length.light_year');
$y = $x->convert('length.metre');
print "$x is $y \n";
?>

<?php
$x = new Quantity(0.1, IAU::parsec);
$y = $x->convert(SI::metre);
print "$x is $y \n";
?>

<?php
$x = new Quantity(12, IAU::parsec);
$y = $x->convert(IAU::light_year);
print "$x is $y \n";
?>

<?php
$x = new Quantity(250e6, IAU::light_year);
$y = $x->convert(IAU::parsec);
print "$x is $y \n";
$z = $y->convert(SI::metre);
print "$y is $z \n";
try {
	$u = $z->convert(SI::second);
	print "$z is $u \n";
} catch(\Error $e) {
	print "\n ⚠ $e \n";
}
?>

<?php
$x = new Quantity(5, Imperial::pound);
$y = $x->convert(SI::kilogram);
print "$x is $y \n";
?>

<?php
$x = new Quantity(3, NonStandard::year);
$y = $x->convert(SI::second);
print "$x is $y \n";
?>

<?php
$x = new Quantity(17, SI::ampere);
$y = $x->convert(CGS::abampere);
print "$x is $y \n";
$z = $y->convert(CGS::statampere);
print "$y is $z \n";
$u = $z->convert(SI::ampere);
print "$z is $u \n";
?>

<?php
$x = new Quantity(100, SI::kelvin);
$y = $x->convert(NonStandard::celsius);
print "$x is $y \n";
$z = $y->convert(Imperial::fahrenheit);
print "$y is $z \n";
$u = $z->convert(NonStandard::rankine);
print "$z is $u \n";
$v = $u->convert(SI::kelvin);
print "$u is $v \n";
?>

<?php
$x = new Quantity(0.0000000017, SI::kelvin);
$y = $x->convert(NonStandard::celsius);
print "$x is $y \n";
$z = $y->convert(Imperial::fahrenheit);
print "$y is $z \n";
$u = $z->convert(NonStandard::rankine);
print "$z is $u \n";
$v = $u->convert(SI::kelvin);
print "$u is $v \n";
?>

<?php
$x = new Quantity(273.150000000017, SI::kelvin);
$y = $x->convert(NonStandard::celsius);
print "$x is $y \n";
$z = $y->convert(Imperial::fahrenheit);
print "$y is $z \n";
$u = $z->convert(NonStandard::rankine);
print "$z is $u \n";
$v = $u->convert(SI::kelvin);
print "$u is $v \n";
?>
</pre>