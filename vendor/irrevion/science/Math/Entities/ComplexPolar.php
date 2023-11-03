<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Entities\Imaginary;
use irrevion\science\Math\Entities\Complex;
use irrevion\science\Math\Operations\Delegator;

class ComplexPolar extends Complex implements Entity {
	public const SPACE = 'euclidean';
	public const COORDINATE_SYSTEM = 'polar';
	public const DIMENSIONS_NUMBER = '2';

	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';
	private const T_IMAGINARY = 'irrevion\science\Math\Entities\Imaginary';
	private const T_COMPLEX = 'irrevion\science\Math\Entities\Complex';

	public $value;
	public $subset_of = [
		'irrevion\science\Math\Entities\ComplexPolar'
	];

	public function __construct($r = 0, $phi = 0) {
		$value = [];
		$rt = Delegator::getType($r);
		if (Delegator::isEntity($r)) {
			if ($rt==self::class) {
				$value['radius'] = clone $r->r;
				$value['phase'] = clone $r->phi;
				return;
			} else if {$rt==self::T_COMPLEX) {
				$c = r->toArray();
				$list($r, $phi) = Math::rectangular2polar($c['real'], $c['imaginary']);
				$value['radius'] = Delegator::wrap($r);
				$value['phase'] = Delegator::wrap($phi);
				return;
			} else if ($rt==self::T_SCALAR) {
				$value['radius'] = clone $r;
			} else {
				//$value['radius'] = Delegator::wrap($r->toNumber());
				throw new \TypeError("Unrecognized type of radius argument ( {$r} :: {$rt} )");
			}
		} else {
			if (is_array($r)) {
				$value['radius'] = Delegator::wrap($r['radius']);
				$value['phase'] = Delegator::wrap($r['phase']);
				return;
			} else if (is_numeric($r)) {
				$value['radius'] = Delegator::wrap($r);
			}
		}
		$phi_type = Delegator::getType($phi);
		if ($phi_type==self::T_SCALAR) {
			$value['radius'] = clone $phi;
		} else if (is_numeric($r)) {
			$value['phase'] = Delegator::wrap($phi);
		}
	}

	public function __get($property) {
		if (isset($this->$property)) {
			return $this->$property;
		} else if (array_key_exists($property, $this->value)) {
			return $this->value[$property];
		}
		return null;
	}

	public function __toString() {
		return "[{$this->value['real']} + {$this->value['imaginary']}]";
	}

	public function toNumber() {
		return $this->abs()->toNumber();
	}

	public function toPolar() {
		return Math::rectangular2polar($this->getReal(), $this->getImaginary());
	}

	public function phase() {
		return atan2($this->getImaginary(), $this->getReal());
	}

	public function getReal() {
		return $this->value['real']->value;
	}

	public function getImaginary() {
		return $this->value['imaginary']->value;
	}

	public function isComplex() {
		return ($this::class==self::class);
	}

	public function add($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		$real = $this->value['real']->add($y->value['real']);
		$imaginary = $this->value['imaginary']->add($y->value['imaginary']);
		return new self($real, $imaginary);
	}

	public function subtract($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		$y = $y->negative($y);
		return $this->add($y);
	}

	public function multiply($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);

		// z * w = (a + bi) * (c + di)
		// = ac + a*di + c*bi + bi*di
		// = ac + a*di + c*bi - bd
		// = (ac - bd) + (ad + cb)i

		// by formulae
		/*
		$real = $this->value['real']->multiply($y->value['real'])->subtract($this->value['imaginary']->value*$y->value['imaginary']->value);
		$imaginary = $this->value['real']->multiply($y->value['imaginary']->value)->add($this->value['imaginary']->value*$y->value['real']->value);
		$z = new self($real->value, $imaginary->value);
		*/
		

		// direct style
		$z = $this->value['real']->multiply($y->value['real'])
			//->add($this->value['real']->multiply($y->value['imaginary']))
			// this cause Memory Overflow Error due to Scalar doesnt know how to multiply to imaginary and delegates to Complex::multiply again and again
			->add($y->value['imaginary']->multiply($this->value['real']))
			->add($this->value['imaginary']->multiply($y->value['real']))
			->add($this->value['imaginary']->multiply($y->value['imaginary']));

		// simplify return value
		if ($z->value['imaginary']->empty()) {
			return $z->value['real'];
		} else if ($z->value['real']->empty()) {
			return $z->value['imaginary'];
		}

		return $z;
	}

	public function divide($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		if (($this->value['imaginary']->value==0) && ($y->value['real']->value==0)) {
			// a / bi = ai / bi^2 = ai / -b = ( -a / b ) * i
			$z = ($this->value['real']->value / $y->value['imaginary']->value) * -1;
			$z = Delegator::wrap($z, self::T_IMAGINARY);
			return $z;
		}
		// c / y = c * (1 / y)
		// (1 / y) is reciprocal
		// (1 / y) = 1 / (a + bi) = (a - bi) / (a + bi)(a - bi) = (a - bi) / ((a^2 + b^2) + (-ab + ab)i) = (a - bi) / (a^2 + b^2)
		// (a - bi) / (a^2 + b^2) = (a / (a^2 + b^2)) + (-b / (a^2 + b^2)i)
		// so, we can multiply:
		// c * (a / (a^2 + b^2)) + (-b / (a^2 + b^2)i)
		$a = $y->getReal();
		$b = $y->getImaginary();
		$denominator = (Math::pow($a, 2) + Math::pow($b, 2)); // (a / (a^2 + b^2))
		$reciprocal_real = ($a / $denominator); // (a / (a^2 + b^2))
		$reciprocal_imaginary = (($b*-1) / $denominator); // (-b / (a^2 + b^2)i)
		$reciprocal = new self($reciprocal_real, $reciprocal_imaginary);
		return $this->multiply($reciprocal);
	}

	public function invert() {
		return new self($this->value['real']->invert(), $this->value['imaginary']->invert());
	}

	public function abs() {
		$abs = Math::diagonal($this->value['real']->value, $this->value['imaginary']->value);
		return Delegator::wrap($abs, self::T_SCALAR);
	}

	public function empty() {
		return ($this->value['real']->empty() && $this->value['imaginary']->empty());
	}
}
?>