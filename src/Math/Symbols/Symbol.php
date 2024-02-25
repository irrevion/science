<?php
namespace irrevion\science\Math\Symbols;

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Symbols\{ISymbol, Symbols, Expression};


class Symbol implements ISymbol {

	public $name = '';
	public $value = null;
	public $is_expr = false;
	public $is_const = false;

	public function __construct(?string $name=null, mixed $value=null) {
		if (is_null($name)) {
			$name = Symbols::suggestName();
		}

		if (strpbrk($name, '+=-*/(){}[]$%!\'\"\\ ?:;.,')!==false) throw new \Error('Invalid symbolic name');

		if (isset(Symbols::$registry[$name])) {
		// or if (Symbols::isNameTaken($name)) {
			throw new \Error('Symbol name cannot be reused');
		}
		$this->name = $name;
		Symbols::$registry[$name] = $this;
		// or Symbols::takeName($name, $this);

		if (!is_null($value)) {
			$this->assign($value);
		}
	}

	public function asConst() {
		$this->is_const = true;
		return $this;
	}

	public function asExpr() {
		$this->is_expr = true;
		return $this;
	}

	public function __toString(): string {
		if ($this->is_const) return "{$this->value}";
		return "{{$this->name}}";
	}

	public function isAssigned(): bool {
		return !is_null($this->value);
	}

	public function isEqual(Symbol $symbol): bool {
		return ($this->name===$symbol->name);
	}

	public function isConst(): bool {
		return $this->is_const;
	}

	public function isExpr(): bool {
		return $this->is_expr;
	}

	public function assign($value) {
		if ($this->is_expr) {
			return $this->value->assign($value);
		}
		// assign value, entity or expression to symbol
		//$type = Delegator::getType($value);
		if (Delegator::isNumber($value)) $value = Delegator::wrap($value); // convert number to Scalar
		//print "{$this->name}: $type to ".Delegator::getType($value);
		$this->value = $value;
		return $this;
	}

	public function evaluate() {
		if ($this->is_expr) {
			return $this->value->evaluate();
		}
		return $this->value;
	}

	public function substitute($value) {
		return $this->assign($value)->evaluate();
	}

	public function add(mixed $smth): Expression {
		// $smth can be a number, an Entity, an Expression, a Symbol
		$me = ($this->is_expr? $this->value: $this);
		// return new Expression(Operations::op('Add')->over($this)->with($smth));
		return new Expression(Operations::op('Add')->over($me)->with($smth));
	}

	public function multiply(mixed $smth): Expression {
		$me = ($this->is_expr? $this->value: $this);
		// return new Expression(Operations::op('Multiply')->over($this)->with($smth));
		return new Expression(Operations::op('Multiply')->over($me)->with($smth));
	}

	public function subtract(mixed $smth): Expression {
		$me = ($this->is_expr? $this->value: $this);
		return new Expression(Operations::op('Subtract')->over($me)->with($smth));
	}

	public function divide(mixed $smth): Expression {
		$me = ($this->is_expr? $this->value: $this);
		return new Expression(Operations::op('Divide')->over($me)->with($smth));
	}

	public function power(mixed $smth): Expression {
		$me = ($this->is_expr? $this->value: $this);
		return new Expression(Operations::op('Power')->over($me)->with($smth));
	}

	public function negative(): Expression {
		return new Expression(Operations::op('Negative')->over($this->is_expr? $this->value: $this));
	}

	public function factorial(): Expression {
		return new Expression(Operations::op('Factorial')->over($this->is_expr? $this->value: $this));
	}
}

?>