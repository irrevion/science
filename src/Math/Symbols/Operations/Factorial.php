<?php
namespace irrevion\science\Math\Symbols\Operations;

use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, NaN};
use irrevion\science\Math\Symbols\Operations\IOperation;
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};


class Factorial extends Operation {

	public $symbols = [];
	public $params = [];
	public $over = [];
	public $with = [];

	public function __construct() {
		// a! --> (new Factorial())->over(a)->assign([a => 4])->perform() --> 24
	}

	public function __toString(): string {
		return "{$this->over['a']}!";
	}

	public function over($a) {
		$a = Symbols::wrap($a, Scalar::class); // convert to symbol if constant
		$this->symbols[$a->name] = $a;
		$this->over['a'] = $a;
		return $this;
	}

	public function assign($params) {
		foreach ($this->symbols as $sym) {
			if (isset($params[$sym->name])) $sym->assign($params[$sym->name]);
		}
		return $this;
	}

	public function evaluate() {
		$a = $this->val($this->over['a']->name);
		$result = Math::factorial($a);
		if (is_null($result)) {
			throw new \Error('Invalid operation result: cannot be null; NaN to be returned instead of null');
		}
		return $result;
	}
}
?>