<?php
namespace irrevion\science\Math;

use irrevion\science\Math\Branches\BaseMath;
use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Entities\{NaN, Scalar, Fraction, Imaginary, Complex, ComplexPolar, QuaternionComponent, Quaternion, Vector};

class Math extends BaseMath {
	public static function abs($x) {
		if (is_object($x)) {
			if (Delegator::isEntity($x)) {
				if (method_exists($x, 'abs')) {
					return $x->abs();
				} else {
					throw new \Error("Method not implemented by Entity");
				}
			}
		} else if (is_numeric($x)) {
			return parent::abs($x);
		} else {
			return null;
		}
	}

	public static function asin($x) {
		if (Delegator::isEntity($x)) {
			return new Scalar(parent::asin($x->toNumber()));
		}
		return parent::asin($x);
	}

	public static function acos($x) {
		if (Delegator::isEntity($x)) {
			return new Scalar(parent::acos($x->toNumber()));
		}
		return parent::acos($x);
	}

	public static function compare($x=0.0, $rel='==', $y=0.0) {
		if (Delegator::isEntity($x)) {$x = $x->toNumber();}
		if (Delegator::isEntity($y)) {$y = $y->toNumber();}
		return parent::compare($x, $rel, $y);
	}

	public static function cos($x) {
		if (Delegator::isEntity($x)) {
			return new Scalar(parent::cos($x->toNumber()));
		}
		return parent::cos($x);
	}

	public static function exp($n) {
		// exponentiation of eⁿ
		// where n is scalar number
		// for exponentiation of e to imaginary or complex power use Complex::exp()
		if (Delegator::isEntity($n)) {
			return new Scalar(parent::exp($n->toNumber()));
		}
		return parent::exp($n);
	}

	public static function factorial($n) {
		if (Delegator::isEntity($n)) {
			if (self::fmod($n->toNumber(), 1)) return new NaN;
			$n = clone $n;
			$f = new ($n::class)(1);
			while (!($n->empty() || $n->isNear(0))) {
				$f = $f->multiply($n);
				$n = $n->subtract(new ($n::class)(1));
			}
			return $f;
		}
		return parent::factorial($n);
	}

	public static function isFloat($n) {
		if (Delegator::isEntity($n)) $n = $n->toNumber();
		return parent::isFloat($n);
	}

	public static function isNaN($n) {
		if (Delegator::isEntity($n)) $n = $n->toNumber();
		return parent::isNaN($n);
	}

	public static function isNatural($n) {
		return (self::isReal($n) && !self::isNaN($n) && !self::isFloat($n) && !self::isNegative($n));
	}

	public static function isNegative($n) {
		if (self::isNaN($n)) {return null;}
		if (self::sign($n)===-1) {return true;}
		return false;
	}

	public static function isReal($n) { // checks if entity has real number representation
		if (Delegator::isEntity($n)) {
			$t = Delegator::getType($n);
			if (in_array($t, [Scalar::class, Fraction::class])) {
				return true;
			} else if ($t==Complex::class) {
				return $n->imaginary->isNear(new Imaginary(0));
			} else if ($t==ComplexPolar::class) {
				return $n->phi->isNear(0);
			} else if ($t==Quaternion::class) {
				return $n->vector->magnitude()->isNear($n->vector[0]);
			} else if ($t==Vector::class) {
				return $n->magnitude()->isNear($n[0]);
			}
		} else {
			return is_numeric($n);
		}
		return false;
	}

	public static function ln($n) {
		if (Delegator::isEntity($n)) {
			return new Scalar(parent::ln($n->toNumber()));
		}
		return parent::ln($n);
	}

	public static function pow($base, $exponent=1) {
		$base_type = Delegator::getType($base);
		$base_is_subset_of_complex = (Delegator::isEntity($base) && Delegator::belongsTo($base, Complex::class));
		$exp_type = Delegator::getType($exponent);

		if (in_array($exp_type, [Imaginary::class, Complex::class]) && $base_is_subset_of_complex) {
			return (new Complex($base))->powI($exponent);
		}

		if (Delegator::isEntity($base)) {
			$exponent_numeric = (Delegator::isEntity($exponent)? $exponent->toNumber(): ($exponent*1));
			$is_fractional_exp = self::fmod($exponent_numeric, 1);
			$exponent_fractional = ($is_fractional_exp?
				((Delegator::getType($exponent)==Fraction::class)?
					$exponent:
					(new Fraction($exponent))
				):
				null
			);

			if ($is_fractional_exp) {
				if (method_exists($base, 'pow')) {
					if (method_exists($base, 'root')) {
						return $base->root($exponent_fractional->denominator)->pow($exponent_fractional->numerator);
					} else {
						return $base->pow($exponent);
					}
				} else if ($base_is_subset_of_complex) {
					$base_num = $base->toNumber();
					if ($base_num<0) {
						if ($exponent_fractional->denominator->value%2) {
							// odd root, result gonna be negative real number
							// But! PHP returns NaN, Python and other calculators returns complex
							// lets stick with negative real number as root
							return Delegator::wrap(parent::pow(abs($base_num), $exponent_numeric), $base::class)->negative();
						} else {
							// even root, result gonna be complex number
							$C = new Complex($base);
							return Math::pow($C->root($exponent_fractional->denominator), $exponent_fractional->numerator);
						}
					}
					return Delegator::wrap(parent::pow($base_num, $exponent_numeric), $base::class);
				}
			} else {
				if (method_exists($base, 'pow')) {return $base->pow($exponent);}
				if (in_array($base_type, [Scalar::class, Fraction::class])) {return Delegator::wrap(self::pow($base->toNumber(), $exponent_numeric), $base_type);}
			}

			if ($exponent_numeric==0) {
				// x^0 = 1
				return Delegator::wrap(1);
			} else if ($exponent_numeric==1) {
				// x^1 = x
				return $base;
			} else if ($exponent_numeric>0) {
				// x^{2, 3, ... , n}
				return $base->multiply(self::pow($base, $exponent_numeric-1));
			} else if ($exponent_numeric<0) {
				// x^{-1, -2, -3, ... , -n}
				$denominator = self::pow($base, self::abs($exponent_numeric));
				if ($denominator->empty()) {return new NaN;}
				return Delegator::wrap(1)->divide($denominator);
			}
		} else if (is_numeric($base)) {
			$exponent = (Delegator::isEntity($exponent)? $exponent->toNumber(): ($exponent*1));
			$result = parent::pow($base, $exponent);
			return (is_nan($result)? (new NaN): $result);
		} else {
			return new NaN;
		}
	}

	public static function sign($n) {
		if (Delegator::isEntity($n)) $n = $n->toNumber();
		return parent::sign($n);
	}

	public static function sin($x) {
		if (Delegator::isEntity($x)) {
			return new Scalar(parent::sin($x->toNumber()));
		}
		return parent::sin($x);
	}

	public static function sum($array, $wrap=null) {
		$res = 0;
		if (count($array)) {
			if (Delegator::isEntity($array[0])) {
				$res = Delegator::wrap($res, Delegator::getType($array[0]));
				foreach ($array as $value) {
					$res = $res->add($value);
				}
			} else {
				$res = parent::sum($array);
			}
		}
		if (!empty($wrap)) {
			Delegator::wrap($res, $wrap);
		}
		return $res;
	}
}
?>