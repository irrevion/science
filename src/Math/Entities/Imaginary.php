<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Operations\Delegator;

class Imaginary extends Scalar implements Entity {
	private const T_SCALAR = __NAMESPACE__.'\Scalar';

	public $value;
	public $subset_of = [
		__NAMESPACE__.'\Complex',
		__NAMESPACE__.'\Quaternion',
		__NAMESPACE__.'\Vector'
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
		return (string)$this->value."i";
	}

	public function toScalar() {
		// use when you need the coefficient only without imaginary properties
		return new (Scalar::class)($this->value);
	}

	public function isImaginary() {
		return ($this::class==self::class);
	}

	public function add($x) {
		if (is_object($x)) {
			if ($x::class==self::class) {
				// Sum Imaginary numbers
				// ai + bi = (a + b)i
				$result = $this->value + $x->value;
				return new self($result);
			} else if (Delegator::isEntity($x)) {
				return Delegator::delegate('add', $this, $x);
			}
		} else if (is_numeric($x)) {
			throw new \TypeError("Built-in types casting not allowed due to ambiguity. Explicitly convert either to Scalar or to Imaginary.");
		} else {
			// No addition method found for this type
			$type = gettype($x);
			if ($type=="object") {
				$type = $x::class;
			}
			throw new \TypeError("Invalid argument type ( {$type} )");
		}
	}

	public function subtract($x) {
		if (is_numeric($x)) {
			throw new \TypeError("Built-in types casting not allowed for imaginary numbers due to ambiguity. Explicitly convert either to Scalar or to Imaginary.");
		} else if (is_object($x)) {
			if ($x::class==self::class) {
				$z = $this->add($x->negative());
				return $z;
			} else if (Delegator::isEntity($x)) {
				return Delegator::delegate('subtract', $this, $x);
			}
		}
		throw new \Error('Unsupported argument type');
	}

	public function multiply($x) {
		if (is_object($x)) {
			// ai * b = (ab)i
			// ai * bi = (ab)i^2 = (ab) * -1 = -ab
			if ($x::class==self::class) {
				$z = $this->value * $x->value * -1;
				return Delegator::wrap($z, self::T_SCALAR);
			} else if ($x::class==self::T_SCALAR) {
				$z = $this->value * $x->value;
				return new self($z);
			} else if (Delegator::isEntity($x)) {
				return Delegator::delegate('multiply', $this, $x);
			}
		}
		throw new \TypeError("Built-in types casting not allowed for imaginary numbers due to ambiguity. Explicitly convert either to Scalar or to Imaginary.");
	}

	public function divide($x) {
		if (is_object($x)) {
			// ai / bi = a / b
			// ai / b = a/b * i
			// a / bi = ai / bi^2 = ai / -b = ( -a / b ) * i
			if ($x::class==self::class) {
				$z = $this->value / $x->value;
				return Delegator::wrap($z, self::T_SCALAR);
			} else if ($x::class==self::T_SCALAR) {
				$z = $this->value / $x->value;
				return new self($z);
			} else if (Delegator::isEntity($x)) {
				return Delegator::delegate('divide', $this, $x);
			}
		}
		throw new \TypeError("Built-in types casting not allowed for imaginary numbers due to ambiguity. Explicitly convert either to Scalar or to Imaginary.");
	}

	public function pow($n) {
		if (!Delegator::isEntity($n)) {$n = Delegator::wrap($n*1.0);}
		if (Delegator::getType($n)!=self::T_SCALAR) {return Delegator::delegate('pow', $this, $n);}
		$k = new Scalar(Math::pow($this->value, $n->value));
		$i = new self(1);
		// i**0=1; i**1=i; i**2=-1; i**3=-i; i**4=1;
		$pattern = [1, $i, -1, $i->negative()];
		$axis = $pattern[($n->toNumber()%4)];
		$result = $k->multiply($axis);
		return $result;
	}

	public function abs() {
		// return new self(abs($this->value));
		return Delegator::wrap(abs($this->value), self::T_SCALAR);
	}

	public function invert() {
		return new self($this->value*-1);
	}

	public function isEqual($y): bool {
		if (Delegator::getType($y)!=self::class) return false;
		return ($this->value==$y->value);
	}

	public function isNear($y): bool {
		if (Delegator::getType($y)!=self::class) return false;
		return Math::compare($this->value, '==', $y->value);
	}
}
?>