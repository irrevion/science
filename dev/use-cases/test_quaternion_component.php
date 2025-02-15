<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('html_errors', true);

require_once("../autoloader.php");

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Helpers\Utils;
use irrevion\science\Math\Entities\{NaN, Scalar, Fraction, Imaginary, Complex, ComplexPolar, Vector, QuaternionComponent, Quaternion};
?>

<pre>

- - - - - - - Quaternion component - - - - - - - -

<?php
Utils::test(
	fn: function() {
		$i = new QuaternionComponent(1);
		return $i;
	},
	check: function($res, $err) {
		return ("$res"==='1i');
	},
	descr: 'create 1i component'
);
?>

<?php
Utils::test(
	fn: function() {
		$k = new QuaternionComponent(2, 'k');
		return $k;
	},
	check: function($res, $err) {
		return ("$res"==='2k');
	},
	descr: 'create 2k component'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(-3, 'j');
		return $j;
	},
	check: function($res, $err) {
		return ("$res"==='-3j');
	},
	descr: 'create -3j component'
);
?>

<?php
Utils::test(
	fn: function() {
		$m = new QuaternionComponent(-12.45, 'm');
		return $m;
	},
	check: function($res, $err) {
		return ($err->getMessage()==='Only i, j, k basis symbols allowed');
	},
	descr: 'create invalid component'
);
?>

<?php
Utils::test(
	fn: function() {
		$n = new QuaternionComponent(new NaN);
		return $n;
	},
	check: function($res, $err) {
		return str_starts_with($err->getMessage(), 'Invalid argument type');
	},
	descr: 'create NaN component'
);
?>

<?php
Utils::test(
	fn: function() {
		$n = new QuaternionComponent((new NaN)->toNumber());
		return $n;
	},
	check: function($res, $err) {
		return str_starts_with($err->getMessage(), 'NaN is not a valid argument value');
	},
	descr: 'create float NaN component'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(-3, 'j');
		$k = new QuaternionComponent(7, 'k');
		$q = $j->add($k);
		return $q;
	},
	check: function($res, $err) {
		return ("$res"==='[0 + 0i + -3j + 7k]');
	},
	descr: '-3j + 7k'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(-3, 'j');
		$j2 = new QuaternionComponent(33, 'j');
		$q = $j->add($j2);
		return $q;
	},
	check: function($res, $err) {
		return ("$res"==='30j');
	},
	descr: '-3j + 33j'
);
?>