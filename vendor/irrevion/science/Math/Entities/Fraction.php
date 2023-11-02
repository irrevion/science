<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Math;

class Fraction extends Scalar implements Entity {
	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';

	public $value;
	public $subset_of = [
		'irrevion\science\Math\Entities\Fraction',
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
			if (in_array($type, ['float', 'double'])) {
				if (Math::abs($number)<1e-11) {
					throw new \ValueError("Precision for numerator is too high ( $number )");
				}
				$number = sprintf('%.11f', $number);
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
		$this->simplify();
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

	public function toArray() {
		return [
			'numerator' => $this->value['numerator']->toNumber(),
			'denominator' => $this->value['denominator']->toNumber()
		];
	}

	public function isFraction() {
		return ($this::class==self::class);
	}

	public function simplify() {
		list ($numerator, $denominator) = Math::gcd_simplify($this->top->toNumber(), $this->bottom->toNumber());
		$this->value['numerator']->value = $numerator;
		$this->value['denominator']->value = $denominator;

		// prevent sign in denominator
		if ($this->value['denominator']->value<0) {
			// $this->value['numerator']->value*=-1;
			// $this->value['denominator']->value*=-1;
			$this->value['numerator'] = Delegator::wrap($numerator)->invert();
			$this->value['denominator'] = Delegator::wrap($denominator)->invert();
		}
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

	public function add($y) {
		$type = Delegator::getType($y);
		if ($type==self::class) {
			$y = clone $y;
		} else {
			$y = new self($y);
		}
		// $x = Delegator::wrap($this->__toString(), self::class);
		$x = clone $this;

		if ($y->denominator->value<0) {
			$y->value['numerator']->value*=-1;
			$y->value['denominator']->value*=-1;
		}

		if ($y->denominator->value!=$x->denominator->value) {
			$x->value['numerator'] = $x->numerator->multiply($y->denominator->value);
			$x->value['denominator'] = $x->denominator->multiply($y->denominator->value);
			$y->value['numerator'] = $y->numerator->multiply($this->denominator->value);
			$y->value['denominator'] = $y->denominator->multiply($this->denominator->value);
		}

		$x->value['numerator'] = $x->numerator->add($y->numerator->value);
		$x->simplify();

		return $x;
	}

	public function subtract($y) {
		$type = Delegator::getType($y);
		if ($type==self::class) {
			$y = clone $y;
		} else {
			$y = new self($y);
		}
		$x = clone $this;
		return $x->add($y->invert());
	}

	public function multiply($y) {
		$type = Delegator::getType($y);
		if ($type==self::class) {
			$y = clone $y;
		} else {
			$y = new self($y);
		}
		$x = clone $this;
		$x->value['numerator'] = $x->value['numerator']->multiply($y->numerator);
		$x->value['denominator'] = $x->value['denominator']->multiply($y->denominator);
		$x->simplify();
		return $x;
	}

	public function divide($y) {
		$type = Delegator::getType($y);
		if ($type==self::class) {
			$y = clone $y;
		} else {
			$y = new self($y);
		}
		$x = clone $this;
		$x = $x->multiply($y->reciprocal());
		return $x;
	}

	public function abs() {
		$x = $this->toArray();
		if ($x['numerator']<0) {
			$x['numerator']*=-1;
		}
		if ($x['denominator']<0) {
			$x['denominator']*=-1;
		}
		return new self($x);
	}

	public function invert() {
		$x = $this->toArray();
		if ($x['denominator']<0) {
			$x['denominator']*=-1;
		} else {
			$x['numerator']*=-1;
		}
		return new self($x);
	}

	public function negative() {
		return $this->invert();
	}

	public function reciprocal() {
		$x = clone $this;
		list($top, $bottom) = [$x->bottom, $x->top];
		$x->value['numerator'] = $top;
		$x->value['denominator'] = $bottom;
		$x->simplify();
		return $x;
	}

	public function empty() {
		return ($this->numerator->value==0);
	}
}
?>