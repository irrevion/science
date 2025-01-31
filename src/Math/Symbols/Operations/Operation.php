<?php
namespace irrevion\science\Math\Symbols\Operations;

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Symbols\{Symbol, Expression};


abstract class Operation implements IOperation {

	abstract public array $symbols;

	abstract public function __toString(): string;

	public function assign($params) {
		foreach ($this->symbols as $sym) {
			if ($sym::class===Symbol::class) {
				if (isset($params[$sym->name])) $sym->assign($params[$sym->name]);
			} else if ($sym::class==Expression::class) {
				$sym->assign($params);
			}
		}
		return $this;
	}

	public function val($name) {
		if (!isset($this->symbols[$name])) throw new \Error("Symbol {$name} not found");
		$sym = $this->symbols[$name];
		if ($sym::class===Symbol::class) {
			if (is_null($sym->value)) throw new \Error('Cannot evaluate until all symbols assigned '.$sym);
			return $sym->value;
		} else if ($sym::class==Expression::class) {
			// if (is_null($sym->result)) throw new \Error("Cannot evaluate until all sub expressions evaluated $name($sym)");
			if (is_null($sym->result)) $sym->evaluate();
			return $sym->result;
		} else {
			throw new \Error("Unsupported operand type $name:".Delegator::getType($sym));
		}
	}
}
?>