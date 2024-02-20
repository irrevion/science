<?php
namespace irrevion\science\Math\Symbols\Operations;

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Symbols\Operations\IOperation;
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};


class Add extends Operation {

	public $is_function = false;
	public $symbols = [];
	public $params = [];
	public $over = [];
	public $with = [];

	public function __construct() {
		// a+b --> (new Add())->over(a)->with(b)->assign([a => 4, b => 3.2])->perform() --> 7.2
	}

	public function __toString(): string {
		if ($this->is_function) return "add({$this->over['a']}, {$this->with['b']})";
		return "( {$this->over['a']} + {$this->with['b']} )";
	}

	public function args(...$args) {
		$this->is_function = true;
		list($a, $b) = $args;
		return $this->over($a)->with($b);
	}

	public function over($a) {
		$a = Symbols::wrap($a); // convert to symbol if constant
		$this->symbols[$a->name] = $a;
		$this->over['a'] = $a;
		return $this;
	}

	public function with($b) {
		$b = Symbols::wrap($b); // convert to symbol if constant
		$this->symbols[$b->name] = $b;
		$this->with['b'] = $b;
		return $this;
	}

	public function evaluate() {
		$a = $this->val($this->over['a']->name);
		$b = $this->val($this->with['b']->name);
		if (!method_exists($a, 'add')) {
			throw new \Error('Operand object ‹‹'.Delegator::getType($a).'›› does not support ‹‹add()›› method');
		}
		$result = $a->add($b);
		if (is_null($result)) {
			throw new \Error('Invalid operation result: cannot be null; NaN used to be returned instead of null');
		}
		return $result;
	}
}
?>