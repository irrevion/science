<?php
namespace irrevion\science\Physics\Entities;

use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Unit\Categories;

class Quantity {
	public $value;
	public $unit;

	public function __construct($value, $unit) {
		$this->value = $value;
		$unit = Physics::unit($unit);
		$this->unit = $unit;
	}

	public function __toString() {
		return "{$this->value} {$this->unit['measure']}";
	}

	public function toNumber() {
		return $this->value;
	}

	public function convert($to) {
		return Physics::convert($this, $to);
	}

	public function i($const='') {
		// $reflection = new \ReflectionClass($this->unit);
		// $reflection = $this->unit;
		// if (empty($const)) {
		// 	return $reflection;
		// }
		// return $reflection->getConstant($const);

		return (empty($const)? $this->unit: $this->unit[$const]);
	}
}
?>