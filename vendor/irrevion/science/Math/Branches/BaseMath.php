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

	public static function diagonal($x, $y) {
		return sqrt(pow($x, 2) + pow($y, 2));
	}

	public static function pow($x, $y) {
		return pow($x, $y);
	}
}
?>