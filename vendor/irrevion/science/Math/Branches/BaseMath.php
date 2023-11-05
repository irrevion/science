<?php
namespace irrevion\science\Math\Branches;

class BaseMath {
	const E = M_E;
	const EULER = M_EULER;
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

	public static function diagonal($x, $y) { // same as hypot()
		return sqrt(pow($x, 2) + pow($y, 2));
	}

	public static function exp($num) {
		return exp($num);
	}

	public static function expm1($num) {
		return expm1($num);
	}

	public static function fdiv($x, $y) {
		return fdiv($x, $y);
	}

	public static function floor($num) {
		return floor($num);
	}

	public static function fmod($x, $y) {
		return fmod($x, $y);
	}

	public static function gcd($x, $y) { // greatest common divisor
		$a = abs((int)$x);
		$b = abs((int)$y);
		if ($b>$a) {
			list($a, $b) = [$b, $a]; // swap
		}
		$remnant = $a%$b;
		if ($remnant==0) {return $b;}
		return self::gcd($b, $remnant);
	}

	public static function gcd_simplify($x, $y) { // simplify fraction by gcd
		$gcd = self::gcd($x, $y);
		return [($x/$gcd), ($y/$gcd)];
	}

	public static function hexdec($s) {
		return hexdec($s);
	}

	public static function hypot($x, $y) {
		return hypot($x, $y);
	}

	public static function intdiv($x, $y) {
		return intdiv($x, $y);
	}

	public static function log10($x) {
		return log10($x);
	}

	public static function log1p($x) {
		return log1p($x);
	}

	public static function log($num, $base = M_E) {
		return log($num, $base);
	}

	public static function polar2rectangular($radius, $phase_angle=0) {
		print "polar2rectangular($radius, $phase_angle)\n";
		list($radius, $phase_angle) = self::polar_absolute($radius, $phase_angle);
		$x = $radius * cos($phase_angle);
		$y = $radius * sin($phase_angle);
		return [$x, $y];
	}

	public static function polar_absolute($radius, $phase_angle=0) {
		$radius = abs($radius);
		$phi_sign = (($phase_angle>0)? 1: -1);
		$phi_abs = abs($phase_angle);
		// print "phi_abs $phi_abs;\n";
		$loops = floor($phi_abs / (2 * M_PI));
		if ($loops) {
			$phase_angle = $phi_sign * ($phi_abs - ($loops * (2 * M_PI)));
			// print "reduced $loops loops, new phase_angle is $phase_angle;\n";
		}
		if ($phase_angle<0) {
			$phase_angle = (2 * M_PI) + $phase_angle;
			// print "(".(2 * M_PI).") + $phase_angle;\n";
		}
		return [$radius, $phase_angle];
	}

	public static function pow($x, $y) {
		return pow($x, $y);
	}

	public static function rectangular2polar($x, $y) {
		print "rectangular2polar($x, $y)\n";
		$radius = hypot($x, $y);
		$phase_angle = atan2($y, $x);
		print "rectangular2polar($radius, $phase_angle)\n";
		list($radius, $phase_angle) = self::polar_absolute($radius, $phase_angle);
		print "rectangular2polar + polar_absolute ($radius, $phase_angle)\n";
		return [$radius, $phase_angle];
	}

	public static function sqrt($x) {
		return sqrt($x);
	}
}
?>