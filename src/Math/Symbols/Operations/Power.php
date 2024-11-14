<?php
namespace irrevion\science\Math\Symbols\Operations;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\{Utils, Delegator};
use irrevion\science\Math\Symbols\Operations\IOperation;
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};


class Power extends Operation {

	public $is_function = false;
	public $symbols = [];
	public $params = [];
	public $over = [];
	public $with = [];

	public function __construct() {
		// a ** b --> (new Power())->over(a)->with(b)->assign([a => 4, b => 3.2])->perform() --> 84.448506289465
	}

	public function __toString(): string {
		if ($this->is_function) return "pow({$this->over['a']}, {$this->with['b']})";
		return "( {$this->over['a']} ** {$this->with['b']} )";
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
		$result = Math::pow($a, $b);
		if (is_null($result)) {
			throw new \Error('Invalid operation result: cannot be null; NaN used to be returned instead of null');
		}
		return $result;
	}

	public function base(null|Symbol|Expression $base=null) {
		if (!is_null($base)) $this->over['a'] = $base;
		return $this->over['a'];
	}

	public function exponent(null|Symbol|Expression $exponent=null) {
		if (!is_null($exponent)) $this->with['b'] = $exponent;
		return $this->with['b'];
	}
}
?>