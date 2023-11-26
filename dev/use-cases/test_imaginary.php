<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Entities\Imaginary;
?>

<pre>
<?php
$x = new Imaginary(5);
print("Imaginary to string is {$x}\n");
print("Type of x is ".($x::class)."\n");
unset($x);
?>

<?php
$x = new Imaginary(5);
$y = new Imaginary(3);
$z = $x->add($y);
print("{$x} + {$y} is {$z}\n");
print("Type of z is ".($z::class)."\n");
unset($x, $y, $z);
?>

<?php
print M_PI;
?>
</pre>
