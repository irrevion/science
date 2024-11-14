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
	private const O_NOOP = 'irrevion\science\Math\Symbols\Operations\NoOp';
	private const O_POW = 'irrevion\science\Math\Symbols\Operations\Power';

	public static $formulas = [];


	public static function add(Symbol|Expression $a, Symbol|Expression $b): Expression {
		return new Expression(Operations::op('Add')->over($a)->with($b));
	}

	public static function multiply(Symbol|Expression $a, Symbol|Expression $b): Expression {
		// commutative multiplication
		// ⚠ do not use with matrices and quaternions

		if (($a::class===Symbol::class) && ($b::class==Symbol::class)) {
			if ($a->isConst() && $b->isConst()) {
				// 2*2 = 4
				return new Expression(Operations::op('NoOp')->over($a->value->multiply($b->value)));
			}
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
				return new Expression(Operations::op('Multiply')->over($b->value->over['a'])->with(
						self::multiply($a, $b->value->with['b'])
					)
				);
			}
		}

		if (($a::class===Expression::class) && ($b::class===Symbol::class)) {
			print "MES $a * $b \n";
			return self::multiply($b, $a);
		}

		if (($a::class===Expression::class) && ($b::class===Expression::class)) {
			print "MEE $a * $b \n";
			$a_op = $a->value::class;
			$b_op = $b->value::class;
			if ($a_op===self::O_ADD) { // irrevion\science\Math\Symbols\Operations\Add
				if ($b_op===self::O_ADD) {
					// (a+b)(c+d) = ac+ad+bc+bd
					$xpr = self::multiply($a->value->over['a'], $b->value->over['a']);
					$xpr = self::add($xpr, self::multiply($a->value->over['a'], $b->value->with['b']));
					$xpr = self::add($xpr, self::multiply($a->value->with['b'], $b->value->over['a']));
					$xpr = self::add($xpr, self::multiply($a->value->with['b'], $b->value->with['b']));
			print "MEaEa R $a * $b = $xpr \n";
					return $xpr;
				}
			}
			if ($a_op===self::O_MUL) {
				print "MEmE $a * $b \n";
				if ($b_op===self::O_MUL) {
					return self::group($a, $b);
				}
				//$xpr = self::multiply(self::multiply($a->value->over['a'], $a->value->with['b']), $b);
				//print "MEmE R $a * $b = $xpr \n";
				//return $xpr;
			}
		}

		return new Expression(Operations::op('Multiply')->over($a)->with($b));
	}

	public static function factors(Expression $xpr): array {
		// returns array of factors of multiplicative expression
		if (!self::isMul($xpr)) throw new \Error('Unexpected operation type ('.$xpr->value::class.'), expected Multiply');
		$factors = [];
		$a = $xpr->value->over['a'];
		if (self::isMul($a)) {
			$subfactors = self::factors($a);
			$factors = array_merge($factors, $subfactors);
		} else {
			$factors[] = $a;
		}
		$b = $xpr->value->with['b'];
		if (self::isMul($b)) {
			$subfactors = self::factors($b);
			$factors = array_merge($factors, $subfactors);
		} else {
			$factors[] = $b;
		}
		return $factors;
	}

	public static function group(...$args): Expression {
		$accum = ['k' => null, 'sym' => [], 'xpr' => []];

		$pre_expanded_args = [];
		foreach ($args as $a) {
			if (self::isMul($a)) {
				$pre_expanded_args = array_merge($pre_expanded_args, self::factors($a));
			} else {
				$pre_expanded_args[] = $a;
			}
		}
		$args = $pre_expanded_args;

		foreach ($args as $a) {
			if (self::isConst($a)) {
				$accum['k'] = (is_null($accum['k'])? $a->value: $accum['k']->multiply($a->value));
				print "k $a -> {$accum['k']} \n";
			} else if (self::isSym($a)) {
				$accum['sym'][$a->name] = (empty($accum['sym'][$a->name])? $a: (new Expression(Operations::op('Power')->over($a)->with(
					(self::isSym($accum['sym'][$a->name])? (new Scalar(2)): $accum['sym'][$a->name]->value->with['b']->add(1))
				))));
			} else if (self::isExpr($a)) {
				if (self::isMul($a)) {
					throw new \Error("This operation $a should be already pre-expanded");
				} else if (self::isPow($a) && self::isSym($a->op()->base())) {
					$sym = $a->op()->base();
					$name = $sym->name;
					$accum['sym'][$name] = (empty($accum['sym'][$name])? $a: self::multiplyPowers($accum['sym'][$name], $a));
				} else {
					$accum['xpr'][] = $a;
				}
			}
		}

		$ungroup = [];
		if (!is_null($accum['k'])) $ungroup[] = $accum['k'];
		if (count($accum['sym'])) $ungroup = array_merge($ungroup, $accum['sym']);
		if (count($accum['xpr'])) $ungroup = array_merge($ungroup, $accum['xpr']);
		if (count($ungroup)==1) return new Expression(Operations::op('NoOp')->over($ungroup[0]));
		$c = array_shift($ungroup);
		foreach ($ungroup as $m) {
			$c = new Expression(Operations::op('Multiply')->over($c)->with($m));
		}
		return $c;
	}

	public static function multiplyPowers(Symbol|Expression $a, Symbol|Expression $b): Expression {
		if (self::isSym($a)) $a = new Expression(Operations::op('Power')->over($a)->with(new Scalar(1)));
		if (self::isSym($b)) $b = new Expression(Operations::op('Power')->over($b)->with(new Scalar(1)));
		if (!$a->op()->base()->isEqual($b->op()->base())) throw new \Error('Only powers of the same symbol sums up');
		$power_exponent = (new Expression(Operations::op('Add')->over($a->op()->exponent())->with($b->op()->exponent())))->simplify();
		if (self::isNoOp($power_exponent)) $power_exponent = $power_exponent->value->over['a'];
		$power_expr = new Expression(Operations::op('Power')->over($a->op()->base())->with($power_exponent));
		return $power_expr;
	}

	public static function isSym($a) {
		return (is_object($a) && ($a::class===Symbol::class));
	}

	public static function isExpr($a) {
		return (is_object($a) && ($a::class===Expression::class));
	}

	public static function isConst($a) {
		return (self::isSym($a) && $a->isConst());
	}

	public static function isMul($a) {
		return (self::isExpr($a) && ($a->value::class===self::O_MUL));
	}

	public static function isPow($a) {
		return (self::isExpr($a) && ($a->value::class===self::O_POW));
	}

	public static function isNoOp($a) {
		return (self::isExpr($a) && ($a->value::class===self::O_NOOP));
	}
}

?>