<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Entities\Quantity;
use irrevion\science\Physics\Unit\Categories;
use irrevion\science\Physics\Unit\{SI, Planck, IAU, CGS, Natural, NonStandard, Imperial, USC};
?>

<pre>
<?php
$x = Physics::q(23, Planck::length);
print "Value (23, Plank::length) autoconverted to $x \n";
$x = Physics::q(247.658e12, Planck::time);
print "Value (247e9, Planck::time) autoconverted to $x \n";
?>

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
$z = $y->convert(Planck::length);
print "$y is $z \n";
$u = $y->convert(IAU::parsec);
print "$z is $u \n";
?>

<?php
$x = new Quantity(1, IAU::au);
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

<?php
$x = new Quantity(2e30, IAU::solar_mass);
$y = $x->convert(NonStandard::electron_mass);
print "$x is $y \n";
?>

<?php
$x = new Quantity(3.14, SI::radian);
$y = $x->convert(NonStandard::degree);
print "$x is $y \n";
$z = $y->convert(NonStandard::grad);
print "$y is $z \n";
$w = $z->convert(NonStandard::turn);
print "$z is $w \n";
?>

<?php
$x = new Quantity(220, SI::volt);
$y = $x->convert(CGS::statvolt);
print "$x is $y \n";
?>

<?php
$x = new Quantity(9000, SI::hertz);
$y = $x->convert(SI::caesium133);
print "$x is $y \n";
$x = new Quantity(9192631770, SI::hertz);
$y = $x->convert(SI::caesium133);
print "$x is $y \n";
?>

<?php
$x = new Quantity(314, Natural::hartree);
$y = $x->convert(Natural::eV);
print "$x is $y \n";
?>

<?php
$x = Categories::find('StatAmpere');
print "$x \n";
$x = Categories::find('LightYear');
print "$x \n";
$x = Categories::find('PlanckTime', 'temperature');
print "$x \n";
$x = Categories::find('planck_time', 'time');
print "$x \n";
$x = Categories::find('PlanckTime', 'time');
print "$x \n";
?>

<?php
$x = new Quantity(28.03, Natural::hartree_force);
$y = $x->convert(SI::newton);
print "$x is $y \n";
$z = $y->convert(Planck::force);
print "$y is $z \n";
?>

<?php
$x = new Quantity(10.01, SI::Pa);
$y = $x->convert(CGS::barye);
print "$x is $y \n";
// $z = $y->convert(NonStandard::mmHg);
// print "$y is $z \n";
?>

<?php
$x = new Quantity(23.579, CGS::ergs_per_second);
$y = $x->convert(SI::W);
print "$x is $y \n";
?>

<?php
$x = new Quantity(155.21e32, Natural::e);
$y = $x->convert(SI::C);
print "$x is $y \n";
?>

<?php
$x = new Quantity(3e-13, CGS::abfarad);
$y = $x->convert(SI::farad);
print "$x is $y \n";
?>

<?php
$x = new Quantity(3e6, CGS::abohm);
$y = $x->convert(SI::ohm);
print "$x is $y \n";
$z = $y->convert(CGS::statohm);
print "$y is $z \n";
?>

<?php
$x = new Quantity(6.02225e24, Natural::particle);
$y = $x->convert(SI::mole);
print "$x is $y \n";
?>
</pre>