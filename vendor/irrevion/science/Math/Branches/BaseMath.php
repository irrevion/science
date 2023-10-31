<?php
namespace irrevion\science\Math\Branches;

class BaseMath {
	const E = M_E;
	const LN2 = M_LN2;
	const LNPI = M_LNPI;
	const LN10 = M_LN10;
	const LOG2E = M_LOG2E;
	const LOG10E = M_LOG10E;
	const PI = M_PI;
	const SQRT1_2 = M_SQRT1_2;
	const SQRT2 = M_SQRT2;
	const TAU = 6.2831853071795; // 2 * pi = L / R

	public static function abs($x) {
		return abs($x);
	}

	public static function acos($x) {
		return acos($x);
	}

	public static function acosh($x) {
		return acosh($x);
	}

	public static function asin($x) {
		return asin($x);
	}

	public static function asinh($x) {
		return asinh($x);
	}

	public static function atan($x) {
		return atan($x);
	}

	public static function atan2($y, $x) {
		return atan2($y, $x);
	}

	public static function atanh($x) {
		return atanh($x);
	}

	public static function base_convert($num, $from_base=10, $to_base=16) {
		return base_convert($num, $from_base, $to_base);
	}

	public static function bindec($binary_string) {
		return bindec($binary_string);
	}

	public static function ceil($num) {
		return ceil($num);
	}

	public static function cos($num) {
		return cos($num);
	}

	public static function cosh($num) {
		return cosh($num);
	}

	public static function decbin($num) {
		return decbin($num);
	}

	public static function dechex($num) {
		return dechex($num);
	}

	public static function decoct($num) {
		return decoct($num);
	}

	public static function deg2rad($num) {
		return deg2rad($num);
	}

	public static function diagonal($x, $y) {
		return sqrt(pow($x, 2) + pow($y, 2));
	}

	public static function pow($x, $y) {
		return pow($x, $y);
	}
}
?>