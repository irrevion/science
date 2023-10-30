<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Entities\Imaginary;
use irrevion\science\Math\Operations\Delegator;

class Complex extends Imaginary implements Entity {
	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';
	private const T_IMAGINARY = 'irrevion\science\Math\Entities\Imaginary';

	public $value;
	public $subset_of = [
		'irrevion\science\Math\Entities\Complex'
		// 'irrevion\science\Math\Entities\Vector'
	];

	public function __construct($real = 0, $imaginary = 0) {
		$value = [];
		if (is_object($real)) {
			if ($real::class==self::class) {
				$this->value = $real->value;
				return;
			} else if ($real::class==self::T_SCALAR) {
				$this->value['real'] = $real;
			} else if ($real::class==self::T_IMAGINARY) {
				$this->value['real'] = new Scalar(0);
				$this->value['imaginary'] = $real;
				// can be constructed with only the imaginary part
				return;
			} else {
				throw new \TypeError("Real part of a Complex number should be Scalar");
			}
		} else {
			$this->value['real'] = new Scalar($real);
		}
		if (is_object($imaginary)) {
			if ($imaginary::class==self::T_IMAGINARY) {
				$this->value['imaginary'] = $imaginary;
			} else {
				throw new \TypeError("Imaginary part of a Complex number should be Imaginary type or numeric");
			}
		} else {
			$this->value['imaginary'] = new Imaginary($imaginary);
		}
	}

	public function __toString() {
		return "[{$this->value['real']} + {$this->value['imaginary']}]";
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
			// this cause Memory Overflow Error due to Scalar doesnt know how to multiply to imaginary and delegates to Complex::myltiply again and again
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

	/* public function divide($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		if (($this->value['imaginary']->value==0) && ($y->value['real']->value==0)) {
			// a / bi = ai / bi^2 = ai / -b = ( -a / b ) * i
		}
	} */

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