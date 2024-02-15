<?php
namespace irrevion\science\Math\Symbols\Operations;

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Symbols\Operations\IOperation;
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};


class Subtract extends Operation {

	public $symbols = [];
	public $params = [];
	public $over = [];
	public $with = [];

	public function __construct() {
		// a - b --> (new Subtract())->over(a)->with(b)->assign([a => 4, b => 3.2])->perform() --> 0.8
	}

	public function __toString(): string {
		return "( {$this->over['a']} + {$this->with['b']} )";
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
		if (!method_exists($a, 'subtract')) {
			throw new \Error('Operand object ‹‹'.Delegator::getType($a).'›› does not support ‹‹subtract()›› method');
		}
		$result = $a->subtract($b);
		if (is_null($result)) {
			throw new \Error('Invalid operation result: cannot be null; NaN used to be returned instead of null');
		}
		return $result;
	}
}
?>