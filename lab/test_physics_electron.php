<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/autoloader.php");

use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Entities\Particles\Electron;
use irrevion\science\Physics\Unit\{SI, Planck, IAU, CGS, Imperial, USC, NonStandard};
?>

<pre>
<?php
$λ = Electron::getComptonWavelength();
print "Compton wavelength of electron is $λ \n";
?>
</pre>