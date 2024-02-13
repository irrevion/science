<?php
namespace irrevion\science\Math\Symbols;

interface IExpression {
	public function __toString(): string;
	// public function assign($params); // damn Barbara Liskov!
	// public function evaluate();
}

?>