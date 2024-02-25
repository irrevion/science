<?php
namespace irrevion\science\Math\Symbols;

use irrevion\science\Helpers\{Utils};
use irrevion\science\Math\Entities\{Scalar, NaN};
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};
use irrevion\science\Math\Symbols\Operations;


class ExpressionSimplifier {

	public static $rules = [
		'add_zero', // x+0=x
		//'expand', // x(a+b)=xa+xb; (a+b)(c+d)=ac+ad+bc+bd; (a+b)(a-2c+d)=a^2-2ac+ad+ba-2bc+bd
		'multiply_by_one', // x*1=x
		//'noop', // (x)=x
		//'precalc_const', // 3+2=5
	];

	public static function apply(Expression $expr, ?array $allow_rules=null, ?array $exclude_rules=null): Expression {
		$rules = self::$rules;
		if (!is_null($allow_rules)) $rules = array_intersect($rules, $allow_rules);
		if (!is_null($exclude_rules)) $rules = array_diff($rules, $exclude_rules);
		if (empty($rules)) return $expr;

		if ($expr->value::class===Operations\Add::class) {
			$expr = self::checkOpAdd($expr, $rules);
		}
		if ($expr->value::class===Operations\Multiply::class) {
			$expr = self::checkOpMultiply($expr, $rules);
		}

		return $expr;
	}

	public static function checkOpAdd(Expression $expr, array $allow_rules): Expression {
		$rules_filter = ['add_zero'];
		$rules = array_intersect($allow_rules, $rules_filter);

		foreach ($rules as $rule) {
			if ($expr->value::class!=Operations\Add::class) return $expr;
			$method = 'rule'.Utils::camelCase($rule);
			if (method_exists(self::class, $method)) self::$method($expr);
		}

		if ($expr->value::class===Operations\Add::class) {
			$a = $expr->value->over['a'];
			if ($a->isExpr()) $a->simplify();
		}
		if ($expr->value::class===Operations\Add::class) {
			$b = $expr->value->with['b'];
			if ($b->isExpr()) $b->simplify();
		}

		return $expr;
	}

	public static function checkOpMultiply(Expression $expr, array $allow_rules): Expression {
		$rules_filter = ['multiply_by_one'];
		$rules = array_intersect($allow_rules, $rules_filter);

		foreach ($rules as $rule) {
			if ($expr->value::class!=Operations\Multiply::class) return $expr;
			$method = 'rule'.Utils::camelCase($rule);
			if (method_exists(self::class, $method)) self::$method($expr);
		}

		if ($expr->value::class===Operations\Multiply::class) {
			$a = $expr->value->over['a'];
			//if ($a->isExpr()) $expr->value->over['a'] = $a->simplify();
			if ($a->isExpr()) $a->simplify();
		}
		if ($expr->value::class===Operations\Multiply::class) {
			$b = $expr->value->with['b'];
			//if ($b->isExpr()) $expr->value->with['b'] = $b->simplify();
			if ($b->isExpr()) $b->simplify();
		}

		return $expr;
	}

	public static function ruleMultiplyByOne(Expression $expr) {
		$a = $expr->value->over['a'];
		$b = $expr->value->with['b'];
		if ($a->isConst() && $a->value->isEqual(new Scalar(1))) {
			if ($b->isExpr()) {
				if ($b->value::class===Operations\NoOp::class) {
					$expr->value = $b->value->over('a');
				} else {
					$expr->value = $b->value;
				}
			} else {
				$expr->value = Operations::op('NoOp')->over($b);
			}
			return $expr;
		}
		if ($b->isConst() && $b->value->isEqual(new Scalar(1))) {
			if ($a->isExpr()) {
				if ($a->value::class===Operations\NoOp::class) {
					$expr->value = $a->value->over('a');
				} else {
					$expr->value = $a->value;
				}
			} else {
				$expr->value = Operations::op('NoOp')->over($a);
			}
			return $expr;
		}
		return $expr;
	}
}

?>