<?php
namespace irrevion\science\Math;

use irrevion\science\Math\Branches\BaseMath;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\{Scalar, Fraction, Imaginary};

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
			$x = $x->toNumber();
		}
		return parent::asin($x);
	}

	public static function acos($x) {
		if (Delegator::isEntity($x)) {
			$x = $x->toNumber();
		}
		return parent::acos($x);
	}

	public static function compare($x=0.0, $rel='==', $y=0.0) {
		if (Delegator::isEntity($x)) {$x = $x->toNumber();}
		if (Delegator::isEntity($y)) {$y = $y->toNumber();}
		return parent::compare($x, $rel, $y);
	}

	public static function pow($base, $exponent=1) {
		if (is_object($base)) {
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
					} else {
						return parent::pow($base->toNumber(), $exponent_numeric);
					}
				} else {
					if (method_exists($base, 'pow')) {return $base->pow($exponent);}
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
					return Delegator::wrap(1)->divide(self::pow($base, self::abs($exponent_numeric)));
				}
			}
		} else if (is_numeric($base)) {
			$exponent = (Delegator::isEntity($exponent)? $exponent->toNumber(): ($exponent*1));
			$result = parent::pow($base, $exponent);
			return (is_nan($result)? null: $result);
		} else {
			return null;
		}
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