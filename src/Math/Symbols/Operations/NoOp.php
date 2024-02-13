<?php
namespace irrevion\science\Math\Symbols\Operations;

use irrevion\science\Math\Entities\{Scalar, NaN};
use irrevion\science\Math\Symbols\Operations\IOperation;
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};


class NoOp extends Operation {

	public $symbols = [];
	public $params = [];
	public $over = [];
	public $with = [];

	public function __construct() {
		// a --> (new NoOp())->over(a)->assign([a => 4])->perform() --> 4
	}

	public function __toString(): string {
		return "{$this->over['a']} ";
	}

	public function over($a) {
		$a = Symbols::wrap($a, Scalar::class); // convert to symbol if constant
		$this->symbols[$a->name] = $a;
		$this->over['a'] = $a;
		return $this;
	}

	public function evaluate() {
		$a = $this->val($this->over['a']->name);
		return $a;
	}
}
?>