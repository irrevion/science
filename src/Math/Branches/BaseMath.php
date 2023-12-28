<?php
namespace irrevion\science\Math\Branches;

class BaseMath {
	const E = M_E;
	const E_M = 0.5772156649015; // Euler-Mascheroni Constant
	const EPSILON = 1e-13; // PHP_FLOAT_EPSILON is too small
	const EULER = M_EULER;
	const GOLDEN_RATIO = 1.6180339887499;
	const I_POW_I = 0.2078795763507; // i**i
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

	public static function avg(...$args) {
		// return (array_sum($args) / count($args)); // will lead to int overflow on big numbers
		$avg = 0.0;
		$length = count($args);
		if ($length) foreach ($args as $i=>$x) {$avg+=(($x-$avg)/($i+1));}
		return $avg;
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

	public static function compare(float $x=0.0, string $rel='==', float $y=1e-12) {
		$epsilon = ((self::EPSILON<PHP_FLOAT_EPSILON)? PHP_FLOAT_EPSILON: self::EPSILON);
		// print 'ε '.var_export($epsilon, 1)."\n";
		$epsilon = (self::avg(abs($x), abs($y)) * $epsilon); // relative precision
		// print 'ε '.var_export($epsilon, 1)."\n";
		if ($epsilon<PHP_FLOAT_EPSILON) {
			// cannot be smaller than PHP_FLOAT_EPSILON
			// XXX WRONG!!!
			// you should be able to compare 1e-22 and 1.00000000003e-22
			// $epsilon = PHP_FLOAT_EPSILON;
			if (($x==0) || ($y==0)) {
				$epsilon = PHP_FLOAT_EPSILON;
			}
		} else if ($epsilon>1e-2) {
			// cannot be bigger than epsilon is .01
			$epsilon = 1e-2;
		}
		// print 'ε '.var_export($epsilon, 1)."\n";
		$rels = [
			'=' => 'equal',
			'==' => 'equal',
			'===' => 'equal',
			'!=' => 'not equal',
			'!==' => 'not equal',
			'<>' => 'not equal',
			'>' => 'greater than',
			'>=' => 'greater than or equal',
			'<' => 'less than',
			'<=' => 'less than or equal',
			'<=>' => 'spaceship',
		];
		if (!isset($rels[$rel])) {
			throw new \Error('Unknown comparison operator "'.$rel.'"');
		}
		$result = match($rels[$rel]) {
			'equal' => (abs($x-$y)<$epsilon),
			// 'not equal' => !self::compare($x, '=', $y),
			'not equal' => (abs($x-$y)>=$epsilon),
			'greater than' => ($x>($y+$epsilon)),
			'greater than or equal' => ($x>=$y), // there are possible cases when "equal" returns true but "greater then or equal" return false
			'less than' => ($x<($y-$epsilon)),
			'less than or equal' => ($x<=$y),
			'spaceship' => (self::compare($x, '=', $y)? 0: (self::compare($x, '<', $y)? -1: 1)),
			default => null,
		};
		return $result;
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

	public static function factorial($n) {
		if (is_float($n)) $n = (int)round($n);
		if ($n<0) throw new \Error('Factorial defined only for positive integers');
		if ($n===0) return 1;
		$f = 1.0;
		while ($n) {
			$f*=$n;
			$n--;
		}
		return $f;
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
		if (!$b) {return 1;} // prevent division by zero
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

	public static function isFloat($n) {
		return (!self::isNaN($n) && is_float($n) && self::fmod($n, 1));
	}

	public static function isNaN($n) {
		if (is_null($n) || is_object($n) || is_array($n)) return true;
		$n = floatval($n);
		return (is_nan($n) || is_infinite($n));
	}

	public static function isNatural($n) {
		return (!self::isNaN($n) && !self::isFloat($n) && ($n>=0));
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

	public static function ln($n) {
		return log($n);
	}

	public static function octdec($octal_string) {
		return octdec($octal_string);
	}

	public static function polar2rectangular($radius, $phase_angle=0) {
		list($radius, $phase_angle) = self::polar_absolute($radius, $phase_angle);
		$x = $radius * cos($phase_angle);
		$y = $radius * sin($phase_angle);
		return [$x, $y];
	}

	public static function polar_absolute($radius, $phase_angle=0) {
		$radius = abs($radius);
		$phi_sign = (($phase_angle>0)? 1: -1);
		$phi_abs = abs($phase_angle);
		$loops = floor($phi_abs / (2 * M_PI));
		if ($loops) {
			$phase_angle = $phi_sign * ($phi_abs - ($loops * (2 * M_PI)));
		}
		if ($phase_angle<0) {
			$phase_angle = (2 * M_PI) + $phase_angle;
		}
		return [$radius, $phase_angle];
	}

	public static function pow($x, $y) {
		return pow($x, $y);
	}

	public static function rad2deg($angle) {
		return rad2deg($angle);
	}

	public static function rectangular2polar($x, $y) {
		$radius = hypot($x, $y);
		$phase_angle = atan2($y, $x);
		list($radius, $phase_angle) = self::polar_absolute($radius, $phase_angle);
		return [$radius, $phase_angle];
	}

	public static function round($num, $precision=0, $mode=PHP_ROUND_HALF_UP) {
		return round($num, $precision, $mode);
	}

	public static function sign($n) {
		return (($n<0)? -1: 1);
	}

	public static function sin($x) {
		return sin($x);
	}

	public static function sinh($x) {
		return sinh($x);
	}

	public static function sqrt($x) {
		return sqrt($x);
	}

	public static function sum($array) {
		return array_sum($array);
	}

	public static function tan($x) {
		return tan($x);
	}

	public static function tanh($x) {
		return tanh($x);
	}
}
?>