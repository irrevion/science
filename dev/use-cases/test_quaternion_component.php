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
		$j = new QuaternionComponent(-3.0, 'j');
		return $j->isScalar();
	},
	check: function($res, $err) {
		return ($res===false);
	},
	descr: 'is -3j scalar'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(-3.0, 'j');
		return $j->isImaginary();
	},
	check: function($res, $err) {
		return ($res===false);
	},
	descr: 'is -3j imaginary'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(-3.0, 'j');
		return $j->isQuaternionComponent();
	},
	check: function($res, $err) {
		return ($res===true);
	},
	descr: 'is -3j quaternion component'
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

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(3.00000000001, 'j');
		$j2 = new QuaternionComponent(3.00000000001, 'j');
		$q = $j->subtract($j2);
		return $q;
	},
	check: function($res, $err) {
		return ("$res"==='0j');
	},
	descr: '3j - 3j'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(3.00000000001, 'j');
		$q = $j->subtract(0.00000000001);
		return $q;
	},
	check: function($res, $err) {
		return str_starts_with($err->getMessage(), 'Built-in types casting not allowed for imaginary numbers due to ambiguity.');
	},
	descr: '3j - 0'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(5.73, 'j');
		$q = $j->subtract(new Scalar(-0.73));
		return $q;
	},
	check: function($res, $err) {
		return ("$res"==='[0.73 + 0i + 5.73j + 0k]');
	},
	descr: '5.73j - (-0.73)'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(5.73, 'j');
		$q = $j->subtract(new Complex(2, 3.14));
		return $q;
	},
	check: function($res, $err) {
		return ("$res"==='[-2 + -3.14i + 5.73j + 0k]');
	},
	descr: '5.73j - (2 + 3.14i)'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(3.00000000001, 'j');
		$q = $j->subtract('1j'); // yes, it looks legit, but no, you cant
		return $q;
	},
	check: function($res, $err) {
		return str_starts_with($err->getMessage(), 'Unsupported argument type');
	},
	descr: '3j - 1j but string'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(3, 'j');
		$j2 = new QuaternionComponent((1/3), 'j');
		$q = $j->multiply($j2);
		return $q;
	},
	check: function($res, $err) {
		return ("$res"==='-1');
	},
	descr: '3j * 1/3j'
);
?>

<?php
Utils::test(
	fn: function() {
		$j = new QuaternionComponent(12, 'j');
		$k = new QuaternionComponent(-0.1, 'k');
		$q = $j->multiply($k);
		return $q;
	},
	check: function($res, $err) {
		return ("$res"==='-1.2i');
	},
	descr: '12j * -0.1k'
);
?>