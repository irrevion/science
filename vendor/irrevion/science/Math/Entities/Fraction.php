<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;

class Fraction extends Scalar implements Entity {
	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';

	public $value;
	public $subset_of = [
		'irrevion\science\Math\Entities\Fraction',
		'irrevion\science\Math\Entities\Scalar',
		'irrevion\science\Math\Entities\Complex',
		'irrevion\science\Math\Entities\Vector'
	];

	public function __construct($number) {
		// accepts:
		// String "1/2",
		// Array ['numerator' => Number/Scalar, 'denominator' => Number/Scalar]
		// Number/Scalar
		// Fraction
		$type = Delegator::getType($number);
		if ($type==self::class) {
			$this->value = [
				'numerator' => $number->numerator,
				'denominator' => $number->denominator
			];
		} else if ($type==self::T_SCALAR) {
			$number = $number->toNumber();
			$number = new self($number);
			$this->value = [
				'numerator' => $number->numerator,
				'denominator' => $number->denominator
			];
		} else if (is_numeric($number)) {
			$number*=1;
			if (Math::fmod($number, 1)>0) {
				$number = $this->floatToFraction($number);
				$this->value = [
					'numerator' => Delegator::wrap($number['numerator']),
					'denominator' => Delegator::wrap($number['denominator'])
				];
			} else {
				$this->value = [
					'numerator' => Delegator::wrap($number),
					'denominator' => Delegator::wrap(1)
				];
			}
		} else if ($type=="string") {
			if (strpos($number, "/")) {
				$parts = explode("/", $number, 2);
				list($numerator, $denominator) = $parts;
				if (!is_numeric($numerator) || !is_numeric($denominator)) {
					throw new \ValueError("Invalid Fraction constructor argument ( $numerator / $denominator )");
				}
				$this->value = [
					'numerator' => Delegator::wrap($numerator),
					'denominator' => Delegator::wrap($denominator)
				];
			} else {
				throw new \ValueError("Invalid Fraction constructor argument ( $number )");
			}
		} else if ($type=="array") {
			if (!isset($number['numerator']) || !is_numeric($number['numerator'])) {
				throw new \ValueError("Invalid Fraction constructor argument numerator ( {$number['numerator']} )");
			}
			if (!isset($number['denominator']) || !is_numeric($number['denominator'])) {
				throw new \ValueError("Invalid Fraction constructor argument denominator ( {$number['denominator']} )");
			}
			$this->value = [
				'numerator' => Delegator::wrap($number['numerator']),
				'denominator' => Delegator::wrap($number['denominator'])
			];
		} else {
			throw new \TypeError("Invalid argument type ( {$type} )");
		}
		if ($this->value['denominator']->toNumber()==0) {
			throw new \ValueError("Invalid Fraction constructor argument denominator: division by zero");
		}
	}

	public function __get($property) {
		if ($property=="value") {
			return $this->toNumber();
		} else if (in_array($property, ["dividend", "numerator", "top"])) {
			return $this->value['numerator'];
		} else if (in_array($property, ["divisor", "denominator", "bottom"])) {
			return $this->value['denominator'];
		} else if (isset($this->$property)) {
			return $this->$property;
		}
		return null;
	}

	public function __toString() {
		return $this->value['numerator']->toNumber()."/".$this->value['denominator']->toNumber();
	}

	public function toNumber() {
		return $this->value['numerator']->toNumber() / $this->value['denominator']->toNumber();
	}

	public function isFraction() {
		return ($this::class==self::class);
	}

	public function floatToFraction($float) {
		$numerator = $float;
		$denominator = 1;
		while (Math::fmod($numerator, 1)) {
			$numerator*=10;
			$denominator*=10;
		}
		list ($numerator, $denominator) = Math::gcd_simplify($numerator, $denominator);
		$fraction =  [
			'numerator' => $numerator,
			'denominator' => $denominator
		];
		return $fraction;
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

	public function empty() {
		return ($this->value==0);
	}
}
?>