<?php
namespace irrevion\science\Physics\Entities;

use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Unit\Categories;

class Quantity {
	public $value;
	public $unit;

	// public function __construct(mixed $value, irrevion\science\Physics\Unit\UnitInterface $unit) {
	public function __construct($value, $unit) {
		$this->value = $value;
		if ($unit instanceof \ReflectionClass) {
			$this->unit = $unit;
		} else {
			$this->unit = Categories::get($unit);
		}
	}

	public function __toString() {
		return "{$this->value} ".$this->unit->getConstant('measure');
	}

	public function convert($to) {
		return Physics::convert($this, $to);
	}

	public function i($const='') {
		// $reflection = new \ReflectionClass($this->unit);
		$reflection = $this->unit;
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>