<?php
namespace irrevion\science\Math\Symbols;

use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};
use irrevion\science\Math\Symbols\Operations\{IOperation, NoOp};

class Expressions {

	public static function parse(string $xpr): Expression {
		return (new ExpressionStatement($xpr))->parse()->value;
	}
}
?>