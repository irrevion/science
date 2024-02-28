<?php
namespace irrevion\science\Math\Branches;

use irrevion\science\Helpers\{Utils, Delegator};
use irrevion\science\Math\Math;
use irrevion\science\Math\Transformations\Matrix;
use irrevion\science\Math\Entities\{NaN, Scalar, Fraction, Imaginary, Complex, ComplexPolar, QuaternionComponent, Quaternion, Vector};
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression, Operations};


class SymbolicMath {

	private const O_ADD = 'irrevion\science\Math\Symbols\Operations\Add'; // \irrevion\science\Math\Symbols\Operations\Add::class
	private const O_MUL = 'irrevion\science\Math\Symbols\Operations\Multiply';

	public static $formulas = [];


	public static function add(Symbol|Expression $a, Symbol|Expression $b): Expression {
		return new Expression(Operations::op('Add')->over($a)->with($b));
	}

	public static function multiply(Symbol|Expression $a, Symbol|Expression $b): Expression {
		// commutative multiplication
		// ⚠ do not use with matrices and quaternions

		if (($a::class===Symbol::class) && ($b::class==Symbol::class)) {
			if ($a->name===$b->name) {
				// a*a = a**2
				return new Expression(Operations::op('Power')->over($a)->with(2));
			}
		}

		if (($a::class===Symbol::class) && ($b::class===Expression::class)) {
			$b_op = $b->value::class;
			if ($b_op===self::O_ADD) {
				// a(b+c) = ab+ac
				return new Expression(Operations::op('Add')->over(
						self::multiply($a, $b->value->over['a'])
					)->with(
						self::multiply($a, $b->value->with['b'])
					)
				);
			}
			if (($b_op===self::O_MUL) && ($b->value->over['a']->isConst())) {
				// a*2a = 2a**2
				//throw new \Error('Not implemented yet');
				return new Expression(Operations::op('Multiply')->over($b->value->over['a'])->with(
						self::multiply($a, $b->value->with['b'])
					)
				);
			}
		}

		if (($a::class===Expression::class) && ($b::class===Expression::class)) {
			$a_op = $a->value::class;
			$b_op = $b->value::class;
			if ($a_op===self::O_ADD) { // irrevion\science\Math\Symbols\Operations\Add
				if ($b_op===self::O_ADD) {
					// (a+b)(c+d) = ac+ad+bc+bd
					$exp = self::multiply($a->value->over['a'], $b->value->over['a']);
					$exp = self::add($exp, self::multiply($a->value->over['a'], $b->value->with['b']));
					$exp = self::add($exp, self::multiply($a->value->with['b'], $b->value->over['a']));
					$exp = self::add($exp, self::multiply($a->value->with['b'], $b->value->with['b']));
					return $exp;
				}
			}
		}

		return new Expression(Operations::op('Multiply')->over($a)->with($b));
	}
}

?>