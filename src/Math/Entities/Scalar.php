<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Delegator;

class Scalar implements Entity {
	public $value;
	public $subset_of = [
		__NAMESPACE__.'\Complex',
		__NAMESPACE__.'\Quaternion',
		__NAMESPACE__.'\Vector',
	];

	public function __construct($x = 0) {
		if (is_object($x)) {
			if ($x::class==self::class) {
				$this->value = $x->value;
			} else {
				throw new \TypeError("Invalid argument type ( ".($x::class)." )");
			}
		} else if (is_numeric($x)) {
			$this->value = $x*1;
		} else {
			$type = gettype($x);
			if ($type=="object") {
				$type = $x::class;
			}
			throw new \TypeError("Invalid argument type ( {$type} )");
		}
	}

	public function __toString() {
		return (string)$this->value;
	}

	public function toNumber() {
		return $this->value*1;
	}

	public function isScalar() {
		return ($this::class==self::class);
	}

	public function add($x) {
		if (is_object($x)) {
			if ($x::class==self::class) {
				// Sum Scalars
				$result = $this->value + $x->value;
				return new self($result);
			} else if (Delegator::isEntity($x)) {
				return Delegator::delegate('add', $this, $x);
			}
		} else if (is_numeric($x)) {
			// Cast number to a Scalar type
			$x = new self($x);
			return $this->add($x);
		} else {
			// No addition method found for this type
			$type = gettype($x);
			if ($type=="object") {
				$type = $x::class;
			}
			throw new \TypeError("Invalid argument type ( {$type} )");
		}
		return null;
	}

	public function subtract($x) {
		if (is_object($x)) {
			if ($x::class==self::class) {
				// Subtract Scalars
				$result = $this->value - $x->value;
				return new self($result);
			} else if (Delegator::isEntity($x)) {
				return Delegator::delegate('subtract', $this, $x);
			}
		} else if (is_numeric($x)) {
			// Cast number to a Scalar type
			$x = new self($x);
			return $this->subtract($x);
		} else {
			// No subtraction method found for this type
			$type = gettype($x);
			if ($type=="object") {
				$type = $x::class;
			}
			throw new \TypeError("Invalid argument type ( {$type} )");
		}
		return null;
	}

	public function multiply($x) {
		if (is_object($x)) {
			if ($x::class==self::class) {
				// Multiply Scalars
				$result = $this->value*$x->value;
				return new self($result);
			} else if (Delegator::isEntity($x)) {
				return Delegator::delegate('multiply', $this, $x);
			}
		} else if (is_numeric($x)) {
			// Cast number to a Scalar type
			$x = new self($x);
			return $this->multiply($x);
		} else {
			// No multiplication method found for this type
			$type = gettype($x);
			if ($type=="object") {
				$type = $x::class;
			}
			throw new \TypeError("Invalid argument type ( {$type} )");
		}
		return null;
	}

	public function divide($x) {
		if (is_object($x)) {
			if ($x::class==self::class) {
				// Divide Scalars
				$result = $this->value/$x->value;
				return new self($result);
			} else if (Delegator::isEntity($x)) {
				return Delegator::delegate('divide', $this, $x);
			}
		} else if (is_numeric($x)) {
			// Cast number to a Scalar type
			$x = new self($x);
			return $this->divide($x);
		} else {
			// No division method found for this type
			$type = gettype($x);
			if ($type=="object") {
				$type = $x::class;
			}
			throw new \TypeError("Invalid argument type ( {$type} )");
		}
		return null;
	}

	public function abs() {
		return new self(abs($this->value));
	}

	public function invert() {
		return new self($this->value*-1);
	}

	public function negative() {
		return $this->invert();
	}

	public function reciprocal() {
		return new self(1/$this->value);
	}

	public function empty(): bool {
		return ($this->value==0);
	}

	public function isEqual($y): bool {
		if (Delegator::getType($y)!=$this::class) return false;
		return ($this->toNumber()==$y->toNumber());
	}

	public function isNear($y): bool {
		return Math::compare($this, '==', $y);
	}
}
?>