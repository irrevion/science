<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Helpers\{Utils};
use irrevion\science\Math\Symbols\{Symbol, Symbols, Expression, ExpressionStatement};
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



<?php
Utils::test(
	fn: function() {
		$xpr = new Expression('.0! + 3{g} + (2e-5(700 * -2e3) - 4.89)');
		// 1 + 3*12 + (0.00002*(700 * -2000) - 4.89)
		// 37 + (-28 - 4.89)
		// 4.11
		// parsed as ( ( 0! + ( 3 * {g} ) ) + ( ( 2.0E-5 * ( 700 * -2000 ) ) + 4.89 ) )
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
			//var_dump($err);
			//die();
		}
		$calculated = $res->assign(['g' => 12])->evaluate();
		print "calculated value: $calculated \n";
		//return $calculated->isEqual(new Scalar(4.11));
		return Math::compare($calculated, '=', 4.11);
	},
	descr: 'Calc ( .0! + 3{g} + (2e-5(700 * -2e3) - 4.89) )'
);

?>



<?php
Utils::test(
	fn: function() {
		$xpr = new Expression('.0! + 3{i} + (2e-5(700 * -2e3) - 4.89)');
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
			//var_dump($err);
			//die();
		}
		$calculated = $res->evaluate();
		print "calculated value: $calculated (".Delegator::getType($calculated).") \n";
		//return $calculated->isEqual(new Complex(-31.89, 3));
		return Math::compare($calculated, '=', (new Complex(-31.89, 3)));
	},
	descr: 'Calc ( .0! + 3{i} + (2e-5(700 * -2e3) - 4.89) )'
);

?>



<?php
Utils::test(
	fn: function() {
		// ExpressionStatement::$debug = true;
		$xpr = new Expression('5**5');
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
			//var_dump($err);
			//die();
		}
		$calculated = $res->evaluate();
		print "calculated value: $calculated (".Delegator::getType($calculated).") \n";
		return $calculated->isEqual(new Scalar(3125));
		// return Math::compare($calculated, '=', (new Scalar(3125)));
	},
	descr: 'Calc ( 5**5 )'
);

?>



<?php
Utils::test(
	fn: function() {
		// ExpressionStatement::$debug = true;
		$xpr = new Expression('{e}**({π}{i})');
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
			//var_dump($err);
			//die();
		}
		$calculated = $res->evaluate();
		print "calculated value: $calculated (".Delegator::getType($calculated).") \n";
		return $calculated->isNear(new Complex(-1));
		//return $calculated->isEqual(new Scalar(-1));
		// return Math::compare($calculated, '=', (new Scalar(-1)));
	},
	descr: 'Calc ( e**πi )'
);

?>



<?php
Utils::test(
	fn: function() {
		ExpressionStatement::$debug = false;
		$xpr = new Expression('(3-2)avg(-0.9, pow(5-6, 3), (abs({x}-1)*-1))');
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
		}
		//print "simplified: ".$res->simplify()." \n";
		$calculated = $res->assign(['x' => -0.1])->evaluate();
		print "calculated value: $calculated (".Delegator::getType($calculated).") \n";
		return $calculated->isEqual(new Scalar(-1));
	},
	descr: 'Calc (3-2)avg(-0.9, pow(5-6, 3), (abs({x}-1)*-1))'
);

?>



<?php
Utils::test(
	fn: function() {
		// ExpressionStatement::$debug = true;
		$xpr = new Expression('cos({π})+{i}sin({π})');
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
			//var_dump($err);
			//die();
		}
		$calculated = $res->evaluate();
		print "calculated value: $calculated (".Delegator::getType($calculated).") \n";
		return $calculated->isNear(new Complex(-1));
		// return Math::compare($calculated, '=', (new Scalar(-1)));
	},
	descr: 'Calc ( cos(π)+i sin(π) )'
);

?>



<?php
Utils::test(
	fn: function() {
		// ExpressionStatement::$debug = true;
		$xpr = new Expression('ln( (1e2 - 99) / ( 1 + {e}**(-3{x})))');
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
			//var_dump($err);
			//die();
		}
		$calculated = $res->assign(['x' => -0.6666])->evaluate();
		print "calculated value: $calculated (".Delegator::getType($calculated).") \n";
		return $calculated->isNear(new Scalar(-2.1267518537274));
		// return Math::compare($calculated, '=', (new Scalar(-1)));
	},
	descr: 'Calc ( ln( (1e2 - 99) / ( 1 + {e}**-3{x})) )'
);

?>



<?php
Utils::test(
	fn: function() {
		// ExpressionStatement::$debug = true;
		$xpr = new Expression('exp(4.2)');
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
		}
		$calculated = $res->evaluate();
		print "calculated value: $calculated (".Delegator::getType($calculated).") \n";
		return $calculated->isNear(new Scalar(66.686331040925));
	},
	descr: 'Calc ( exp(4.2) )'
);

?>



<?php
// print (new Complex(2, -4.6))->exp(); // is [-0.82870131315995 + 7.3424385708504i]
Utils::test(
	fn: function() {
		// ExpressionStatement::$debug = true;
		$xpr = new Expression('exp(2 - 4.6{i})');
		return $xpr;
	},
	check: function($res, $err) {
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
		}
		$calculated = $res->evaluate();
		print "calculated value: $calculated (".Delegator::getType($calculated).") \n";
		return $calculated->isNear(new Complex(-0.82870131315995, 7.3424385708504));
	},
	descr: 'Calc ( exp(2 - 4.6i) )'
);

?>



<?php
Utils::test(
	fn: function() {
		//ExpressionStatement::$debug = true;
		$xpr = new Expression('(((((-3*1)))))');
		return $xpr;
	},
	check: function($res, $err) {
		// print_r($res);
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
		}
		return $res->simplify()->isEqual(new Expression('-3'));
	},
	descr: '-3'
);

?>



<?php
Utils::test(
	fn: function() {
		//ExpressionStatement::$debug = true;
		$xpr = new Expression('({f}+{g})({k}+2{g})');
		return $xpr;
	},
	check: function($res, $err) {
		// print_r($res);
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
		}
		return $res->simplify()->isEqual(new Expression('-3'));
	},
	descr: '({f}+{g})({k}+2{g})'
);

?>



<?php
Utils::test(
	fn: function() {
		//ExpressionStatement::$debug = true;
		$xpr = new Expression('2({f}+{g})({k}+2{g})');
		return $xpr;
	},
	check: function($res, $err) {
		// print_r($res);
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
		}
		return $res->simplify()->isEqual(new Expression('-3'));
	},
	descr: '2({f}+{g})({k}+2{g})'
	//descr: '({f}+{g})({k}+{n})'
);

?>



<?php
Utils::test(
	fn: function() {
		//ExpressionStatement::$debug = true;
		$xpr = new Expression('(2*3*{a}**-1*{a}**2)(7*{v}*{a}**3*5)');
		return $xpr;
	},
	check: function($res, $err) {
		// print_r($res);
		if (!is_null($err)) {
			Utils::printErr($err);
			return false;
		}
		return $res->simplify()->isEqual(new Expression('-3'));
	},
	descr: '(2*3*{a}**-1*{a}**2)(7*{v}*{a}**3*5)'
);

?>

</pre>