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

	public function assign(mixed $value): Symbol {
		// assign value, entity or expression to symbol
		//$type = Delegator::getType($value);
		if (Delegator::isNumber($value)) $value = Delegator::wrap($value); // convert number to Scalar
		//print "{$this->name}: $type to ".Delegator::getType($value);
		$this->value = $value;
		return $this;
	}

	public function evaluate() {
		return $this->value;
	}

	public function substitute(mixed $value): mixed {
		return $this->assign($value)->evaluate();
	}

	public function add(mixed $smth): Expression {
		// $smth can be a number, an Entity, an Expression, a Symbol
		return new Expression(Operations::op('Add')->over($this)->with($smth));
	}
	public function ＋(...$args) {return $this->add(...$args);}

	public function multiply(mixed $smth): Expression {
		return new Expression(Operations::op('Multiply')->over($this)->with($smth));
	}
}

?>