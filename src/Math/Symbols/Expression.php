<?php
namespace irrevion\science\Math\Symbols;

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Symbols\{Symbols, Symbol};
use irrevion\science\Math\Symbols\Operations\{IOperation, Operation};

class Expression implements IExpression {

	public $name = '';
	public $value = null;
	public $result = null;
	public $params = [];

	public function __construct($xpr) {
		if (is_string($xpr)) {
			$xpr = Expressions::parse($xpr);
			$this->value = $xpr->value;
			$this->name = $xpr->name;
		} else if (Delegator::implements($xpr, IOperation::class)) {
			$this->value = $xpr;
			$this->name = Symbols::suggestExpressionName();
			Symbols::takeName($this->name)->assign($this)->asExpr();
		} else {
			throw new \Error('Expecting either string or Operation object');
		}
	}

	public function __toString(): string {
		return "{$this->value}";
	}

	public function __call($method, $args) {
		$sym_func = ['add', 'subtract', 'multiply', 'divide', 'power'];
		if (in_array($method, $sym_func)) {
			return Symbols::symbol($this->name)->$method(...$args);
		}
		throw new \Error("Method $method does not exists in ".$this::class);
	}

	public function assign(array $params): Expression {
		$this->params = array_merge($this->params, $params);
		$this->value->assign($this->params);
		return $this;
	}

	public function evaluate() {
		$this->result = $this->value->evaluate();
		if (is_null($this->result)) throw new \Error('Invalid expression result');
		return $this->result;
		//return $this;
	}
}

?>