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
		$y = new self($y);
		$real = $this->value['real']->add($y->value['real']);
		$imaginary = $this->value['imaginary']->add($y->value['imaginary']);
		return new self($real, $imaginary);
	}

	public function subtract($y) {
		$y = new self($y);
		$y = $y->negative($y);
		return $this->add($y);
	}

	public function invert() {
		return new self($this->value['real']->invert(), $this->value['imaginary']->invert());
	}

	public function abs() {
		$abs = Math::diagonal($this->value['real'], $this->value['imaginary']);
		return Delegator::wrap($abs, self::T_SCALAR);
	}
}
?>