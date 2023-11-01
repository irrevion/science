<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/Math/Operations/Delegator.php");
require_once("../vendor/irrevion/science/Math/Branches/BaseMath.php");
require_once("../vendor/irrevion/science/Math/Math.php");
require_once("../vendor/irrevion/science/Math/Entities/Entity.php");
require_once("../vendor/irrevion/science/Math/Entities/Scalar.php");
require_once("../vendor/irrevion/science/Math/Entities/Fraction.php");

use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Entities\Fraction;
?>

<pre>
<?php
$n = new Fraction(5);
print("new Fraction(5) is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);
?>

<?php
$n = new Fraction(5.75);
print("new Fraction(5.75) is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);
?>

<?php
$n = new Fraction("9/666");
print("new Fraction(9/666) is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);
?>

<?php
$n = new Fraction("57e4/94723526");
print("new Fraction(57e4/94723526) is {$n}\n");
print("Type of n is ".($n::class)."\n");
unset($n);
?>

<?php
try {
	$n = new Fraction(14.88e-15);
	print("new Fraction(14.88e-15) is {$n}\n");
	print("Type of n is ".($n::class)."\n");
	unset($n);
} catch (\Error $e) {
	print "Error: ".$e->getMessage()."\n";
}
?>

<?php
try {
	$n = new Fraction(-14.88e-15);
	print("new Fraction(-14.88e-15) is {$n}\n");
	print("Type of n is ".($n::class)."\n");
	unset($n);
} catch (\Error $e) {
	print "Error: ".$e->getMessage()."\n";
}
?>

<?php
try {
	$n = new Fraction(-14.88e-11);
	print("new Fraction(-14.88e-11) is {$n}\n");
	print("Type of n is ".($n::class)."\n");
	unset($n);
} catch (\Error $e) {
	print "Error: ".$e->getMessage()."\n";
}
?>
</pre>
