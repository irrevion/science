<?php
namespace irrevion\science\Math;

use irrevion\science\Math\Branches\BaseMath;
use irrevion\science\Math\Operations\Delegator;

class Math extends BaseMath {
	public static function abs($x) {
		if (is_object($x)) {
			if (Delegator::isEntity($x)) {
				if (method_exists($x, 'abs')) {
					return $x->abs();
				} else {
					throw new \ArithmeticError("Method not implemented by Entity");
				}
			}
		} else if (is_numeric($x)) {
			return parent::abs($x);
		} else {
			return null;
		}
	}

	public static function pow($base, $exponent = 1) {
		$exponent = $exponent * 1;

		if (is_object($base)) {
			if (Delegator::isEntity($base)) {
				if (method_exists($base, 'pow')) {
					return $x->pow($exponent);
				} else {
					if ($exponent==0) {
						// x^0 = 1
						return Delegator::wrap(1);
					} else if ($exponent==1) {
						// x^1 = x
						return $base;
					} else if (($exponent>0) && !($exponent%1)) {
						// x^{2, 3, ... , Integer max}
						return $base->multiply(self::pow($base, $exponent-1));
					} else if (($exponent<0) && !($exponent%1)) {
						// x^{-1, -2, -3, ... , Integer min}
						return Delegator::wrap(1)->divide(Math::pow($base, Math::abs($exponent)));
					} else {
						throw new \ArithmeticError("Method not implemented by Entity");
					}
				}
			}
		} else if (is_numeric($base)) {
			$result = parent::pow($base, $exponent);
			return (is_nan($result)? null: $result);
		} else {
			return null;
		}
	}
}
?>