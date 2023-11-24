<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/autoloader.php");

use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Branches\Relativity;
use irrevion\science\Physics\Entities\Particles\Electron;
use irrevion\science\Physics\Unit\{SI, Planck, IAU, NonStandard};
?>

<pre>
<?php
$λ = Electron::getComptonWavelength();
print "Compton wavelength of electron is $λ \n";
?>

<?php
$λdB = Electron::getDeBroglieWavelength(Physics::c * 0.707106);
print "De Broglie wavelength of electron is $λdB \n";
$λdB = Electron::getDeBroglieWavelength(Physics::q(1, Planck::length)/Physics::q(1, NonStandard::year));
print "De Broglie wavelength of electron is $λdB \n";
$λdB = Electron::getDeBroglieWavelength(10);
print "\n\n De Broglie wavelength of electron is $λdB \n";
$λdB = Electron::getDeBroglieWavelength(20);
print "De Broglie wavelength of electron is $λdB \n";
?>

<?php
$v = 1;
$γ = Relativity::getLorentzFactor($v);
print "Lorentz factor at speed $v m/s is $γ \n";
$v = 100000;
$γ = Relativity::getLorentzFactor($v);
print "Lorentz factor at speed $v m/s is $γ \n";
$v = 3e7;
$γ = Relativity::getLorentzFactor($v);
print "Lorentz factor at speed $v m/s is $γ \n";
$v = Physics::c-1;
$γ = Relativity::getLorentzFactor($v);
print "Lorentz factor at speed $v m/s is $γ \n";
?>
</pre>