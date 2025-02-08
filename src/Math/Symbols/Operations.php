<?php
namespace irrevion\science\Math\Symbols;

use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};
use irrevion\science\Math\Symbols\Operations\{IOperation, Operation};

class Operations {

	public static function op(string $operation_class): IOperation {
		$ns = 'irrevion\\science\\Math\\Symbols\\Operations\\';
		$operation_class = $ns.$operation_class;
		if (!class_exists($operation_class)) throw new \Error("Invalid operation name $operation_class ; no such class exists");
		$class_reflection = new \ReflectionClass($operation_class);
		return $class_reflection->newInstance();
	}
}
?>