<?php
namespace irrevion\science\Math\Symbols\Operations;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Symbols\Operations\IOperation;
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};


class Ln extends Operation {

	public $is_function = true;
	public $symbols = [];
	public $params = [];
	public $over = [];
	public $with = [];

	public function __construct() {
		// ln(x) --> (new Ln())->args($x)->assign(4.2)->perform() --> 1.43508452528
	}

	public function __toString(): string {
		return "ln({$this->over['a']})";
	}

	public function args(...$args) {
		return $this->over($args[0]);
	}

	public function over($a) {
		$a = Symbols::wrap($a); // convert to symbol if constant
		$this->symbols[$a->name] = $a;
		$this->over['a'] = $a;
		return $this;
	}

	public function evaluate() {
		$a = $this->val($this->over['a']->name);
		$result = Math::ln($a);
		if (is_null($result)) {
			throw new \Error('Invalid operation result: cannot be null; NaN used to be returned instead of null');
		}
		return $result;
	}
}
?>