<?php
namespace irrevion\science\Math\Symbols\Operations;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Symbols\Operations\IOperation;
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};


class Avg extends Operation {

	public $is_function = true;
	public $symbols = [];
	public $params = [];
	public $over = [];
	public $with = [];

	public function __construct() {
		// avg(a, b, ... , n) --> (new Power())->args($a, $b, $c, $n)->assign(7, 3, 12, 55)->perform() --> 19.25
	}

	public function __toString(): string {
		return "avg(".implode(', ', $this->over).")";
	}

	public function args(...$args) {
		foreach ($args as $arg) {
			$arg = Symbols::wrap($arg);
			$this->symbols[$arg->name] = $arg;
			$this->over[] = $arg;
		}
		return $this;
	}

	public function evaluate() {
		$args = $this->symbols;
		array_walk($args, function(&$v, $n) {$v = $this->val($n);});
		$result = Math::avg(...$args);
		if (is_null($result)) {
			throw new \Error('Invalid operation result: cannot be null; NaN used to be returned instead of null');
		}
		return $result;
	}
}
?>