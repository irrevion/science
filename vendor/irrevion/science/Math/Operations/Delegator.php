<?php
namespace irrevion\science\Math\Operations;

class Delegator {
	private const ENTITY = 'irrevion\science\Math\Entities\Entity';
	private const ENTITY_SCALAR = 'irrevion\science\Math\Entities\Scalar';

	public static function isEntity($x) {
		if (is_object($x)) {
			$instance_of = $x::class;
			$class_reflection = new \ReflectionClass($instance_of);
			$is_entity = $class_reflection->implementsInterface(self::ENTITY);
			return $is_entity;
		} else if (is_string($x)) {
			$class_reflection = new \ReflectionClass($x);
			$is_entity = $class_reflection->implementsInterface(self::ENTITY);
			return $is_entity;
		}
		return false;
	}

	public static function hasMethod($x, $method_name) {
		if (!self::isEntity($x)) return false;
		if (method_exists($x, $method_name)) return true;
		return false;
	}

	public static function getType($x) {
		$type = gettype($x);
		if ($type=="object") {
			$type = $x::class;
		}
		return $type;
	}

	public static function getSuperset($x, $y) {
		if (!self::isEntity($x)) return null;
		if (!self::isEntity($y)) return null;
		$superX = (empty($x->subset_of)? []: $x->subset_of);
		$superY = (empty($y->subset_of)? []: $y->subset_of);
		$supersets = array_intersect($superX, $superY);
		if (count($supersets)) return $supersets[0];
		return null;
	}

	public static function delegate($operation, $x, $y) {
		$superset = self::getSuperset($x, $y);
		// print "delegate($operation, $x, $y) to $superset\n";
		if (empty($superset)) throw new \ArithmeticError("This entities are incompatible");
		if (!class_exists($superset)) throw new \ArithmeticError("Invalid superset name $superset");
		if (!self::hasMethod($superset, $operation)) throw new \ArithmeticError("Invalid operation to delegate in $superset");
		if (Delegator::getType($x)!=$superset) {$x = self::wrap($x, $superset);}
		if (Delegator::getType($y)!=$superset) {$y = self::wrap($y, $superset);}
		// print $x::class."($x) $operation ".$y::class."($y)\n";
		$z = $x->$operation($y);
		// print $z::class."($z) is result\n-\n";
		return $z;
	}

	public static function wrap($x, $to_superset=null) {
		if (empty($to_superset)) {$to_superset = self::ENTITY_SCALAR;}
		if (self::getType($x)==$to_superset) {return $x;}
		// print "wrap {$x} to {$to_superset} \n";
		$class_reflection = new \ReflectionClass($to_superset);
		return $class_reflection->newInstance($x);
	}
}
?>