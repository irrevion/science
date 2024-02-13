<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Helpers\{Utils};
use irrevion\science\Math\Symbols\{Symbol, Symbols};
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary, Complex, ComplexPolar, Vector, Quaternion};
use irrevion\science\Math\Transformations\Matrix;
?>

<pre>

<?php
Utils::test(
	fn: function() {
		$a = new Symbol('a');
		return $a;
	},
	check: function($res, $err) {
		return ("$res"=="{a}");
	},
	descr: 'Create symbol $a'
);
?>

<?php
Utils::test(
	fn: function() {
		$b = new Symbol();
		$a = $b->assign(7)->evaluate();
		return $a;
	},
	check: function($res, $err) {
		return ("$res"=="7");
	},
	descr: 'Substitute 7 to $b'
);
?>

<?php
Utils::test(
	fn: function() {
		$c = Symbols::symbol('b')->add(3);
		return $c;
	},
	check: function($res, $err) {
		return ("$res"=="( {b} + 3 )");
	},
	descr: '$b+3'
);
?>

<?php
Utils::test(
	fn: function() {
		return Symbols::symbol('b')->add(3)->assign(['b' => 7])->evaluate();
	},
	check: function($res, $err) {
		return ("$res"==10);
	},
	descr: '7+3'
);
?>

<?php
Utils::test(
	fn: function() {
		return Symbols::symbol('π')->add('τ')->evaluate();
	},
	check: function($res, $err) {
		return ("$res"=="9.4247779607693");
	},
	descr: 'π+τ'
);
?>

<?php
Utils::test(
	fn: function() {
		return Symbols::symbol('x')->add('i')->assign(['x' => -7.31])->evaluate();
	},
	check: function($res, $err) {
		return ("$res"=="[-7.31 + 1i]");
	},
	descr: '-7.31 + i'
);
?>

<?php
Utils::test(
	fn: function() {
		return Symbols::symbol('x')->add(new Quaternion([2, 3.7, 0.12, 7.26]))->assign(['x' => 74.16])->evaluate();
	},
	check: function($res, $err) {
		return ("$res"=="[76.16 + 3.7i + 0.12j + 7.26k]");
	},
	descr: '74.16 + [2 + 3.7i + 0.12j + 7.26k]'
);
?>

<?php
Utils::test(
	fn: function() {
		return Symbols::symbol('ratio1')
			->add('ratio2')
			->assign([
				'ratio1' => new Fraction('5/6'),
				'ratio2' => new Fraction('3/4')
			])
			->evaluate();
	},
	check: function($res, $err) {
		return ("$res"=="19/12");
	},
	descr: '5/6 + 3/4'
);
?>

</pre>