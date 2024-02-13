<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Helpers\{Utils};
use irrevion\science\Math\Symbols\{Symbol, Symbols, Expression};
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex, ComplexPolar, Vector, Quaternion};
use irrevion\science\Math\Transformations\Matrix;
?>

<pre>

<?php
Utils::test(
	fn: function() {
		$xpr = new Expression('{x}'); // -3 = -3
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
			// var_dump($err);
			// die();
		}
		return $res->assign(['x' => -3])->evaluate()->isEqual(new Scalar(-3));
	},
	descr: 'Calc ( {x} )'
);
?>



<?php
Utils::test(
	fn: function() {
		$xpr = new Expression('-{x} + {y}'); // -(-3) + -3 = 0
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
			// var_dump($err);
			// die();
		}
		return $res->assign(['x' => -3, 'y' => -3])->evaluate()->isEqual(new Scalar(0));
	},
	descr: 'Calc ( -{x} + {y} )'
);
?>



<?php
Utils::test(
	fn: function() {
		$xpr = new Expression('{x}+({a} + {b}+7) +{y}'); // -1 + (2 + -7 + 7) + 1 = 2
		// parsed as ( ( {x} + ( ( {a} + {b} ) + 7 ) ) + {y} )
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
			//var_dump($err);
			//die();
		}
		return $res->assign(['x' => -1, 'a' => 2, 'b' => -7, 'y' => 1])->evaluate()->isEqual(new Scalar(2));
	},
	descr: 'Calc ( {x}+({a} + {b}+7) +{y} )'
);
?>

</pre>