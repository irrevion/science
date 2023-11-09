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
require_once("../vendor/irrevion/science/Math/Entities/Vector.php");

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Entities\Vector;
?>

<pre>
<?php
$x = new Vector([1,2,3,4,5]);
print("Vector([1,2,3,4,5]) to string is {$x}\n");
print("Type of x is ".($x::class)." of {$x->inner_type}\n");
unset($x);
?>

<?php
try {
	$x = new Vector('kapusta');
	print("Vector('kapusta') to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector('kapusta') -> ".$e->getMessage()."\n";
}
?>

<?php
try {
	$x = new Vector(['k', 'a', 'p', 'u', 's', 't', 'a']);
	print("Vector(['k', 'a', 'p', 'u', 's', 't', 'a']) to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector(['k', 'a', 'p', 'u', 's', 't', 'a']) -> ".$e->getMessage()."\n";
}
?>

<?php
try {
	$x = new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'string');
	print("Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'string') to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	var_dump($x->value);
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'string') -> ".$e->getMessage()."\n";
}
?>

<?php
try {
	$x = new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'float');
	print("Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'float') to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	var_dump($x->value);
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'float') -> ".$e->getMessage()."\n";
} catch (\ReflectionException $e) {
	print "Error: new Vector(['k', 'a', 'p', 'u', 's', 't', 'a'], 'float') -> ".$e->getMessage()."\n";
}
?>

<?php
try {
	$x = new Vector([73, 82, 995], 'irrevion\science\Math\Entities\Complex');
	print("Vector([73, 82, 995], 'irrevion\science\Math\Entities\Complex') to string is {$x}\n");
	print("Type of x is ".($x::class)." of {$x->inner_type}\n");
	var_dump($x->value);
	unset($x);
} catch (\Error $e) {
	print "Error: new Vector([73, 82, 995], 'irrevion\science\Math\Entities\Complex') -> ".$e->getMessage()."\n";
} catch (\ReflectionException $e) {
	print "Error: new Vector([73, 82, 995], 'irrevion\science\Math\Entities\Complex') -> ".$e->getMessage()."\n";
}
?>
</pre>
