<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../vendor/irrevion/science/autoloader.php");

use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Entities\Quantity;
?>

<pre>
<?php
print Physics::unit();
?>

<?php
$x = new Quantity(23, 'length.light_year');
$y = $x->convert('length.metre');
print "$x is $y";
?>
</pre>