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
</pre>
