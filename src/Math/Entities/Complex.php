<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\{
	Scalar, Imaginary
};

class Complex extends Imaginary implements Entity {
	//https://www.youtube.com/watch?v=cUzklzVXJwo&t=19m18s
	public const SPACE = 'euclidean';
	public const COORDINATE_SYSTEM = 'rectangular';
	public const DIMENSIONS_NUMBER = '2';

	private const T_SCALAR = __NAMESPACE__.'\Scalar';
	private const T_FRACTION = __NAMESPACE__.'\Fraction';
	private const T_IMAGINARY = __NAMESPACE__.'\Imaginary';
	private const T_POLAR = __NAMESPACE__.'\ComplexPolar';
	private const T_VECTOR = __NAMESPACE__.'\Vector';

	public $value;
	public $subset_of = [
		__NAMESPACE__.'\Complex',
		__NAMESPACE__.'\Quaternion',
		// __NAMESPACE__.'\Vector'
	];

	public function __construct($real = 0, $imaginary = 0) {
		$value = [];
		if (is_object($real)) {
			if ($real::class==self::class) {
				$this->value = $real->value;
				return;
			} else if (in_array($real::class, [self::T_SCALAR, self::T_FRACTION])) {
				$this->value['real'] = Delegator::wrap($real->toNumber());
			} else if ($real::class==self::T_IMAGINARY) {
				$this->value['real'] = new Scalar(0);
				$this->value['imaginary'] = $real;
				// can be constructed with only the imaginary part
				return;
			} else if ($real::class==self::T_POLAR) {
				$real = $real->toRectangular();
				$this->value['real'] = $real->real;
				$this->value['imaginary'] = $real->imaginary;
				return;
			} else {
				throw new \TypeError("Real part of a Complex number should be Scalar");
			}
		} else if (is_array($real)) {
			$this->value['real'] = new Scalar($real['real']);
			$this->value['imaginary'] = new Imaginary($real['imaginary']);
			return;
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
		list($r, $phi) = Math::rectangular2polar($this->getReal(), $this->getImaginary());
		return Delegator::wrap([
			'radius' => $r,
			'phase' => $phi
		], self::T_POLAR);
	}

	public function toArray() {
		return [
			'real' => $this->getReal(),
			'imaginary' => $this->getImaginary()
		];
	}

	public function toVector() {
		return Delegator::wrap([$this->getReal()->toNumber(), $this->getImaginary()->toNumber()], self::T_VECTOR);
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

		return $this->multiply($y->reciprocal());
	}

	public function reciprocal() {
		// (1 / y) is reciprocal
		// (1 / y) = 1 / (a + bi) = (a - bi) / (a + bi)(a - bi) = (a - bi) / ((a^2 + b^2) + (-ab + ab)i) = (a - bi) / (a^2 + b^2)
		// (a - bi) / (a^2 + b^2) = (a / (a^2 + b^2)) + (-b / (a^2 + b^2)i)
		// so, we can multiply:
		// c * (a / (a^2 + b^2)) + (-b / (a^2 + b^2)i)
		$a = $this->getReal();
		$b = $this->getImaginary();
		$denominator = (Math::pow($a, 2) + Math::pow($b, 2)); // (a / (a^2 + b^2))
		$reciprocal_real = ($a / $denominator); // (a / (a^2 + b^2))
		$reciprocal_imaginary = (($b*-1) / $denominator); // (-b / (a^2 + b^2)i)
		$reciprocal = new self($reciprocal_real, $reciprocal_imaginary);
		return $reciprocal;
	}

	public function conjugate() {
		return new self($this->real, $this->imaginary->negative());
	}

	public function invert() {
		return new self($this->value['real']->invert(), $this->value['imaginary']->invert());
	}

	public function abs() {
		$abs = Math::diagonal($this->value['real']->value, $this->value['imaginary']->value);
		return Delegator::wrap($abs, self::T_SCALAR);
	}

	public function root($n=2, $all_roots=false) {
		if ($this->empty()) {return new self(0);}
		$C = new (self::T_POLAR)($this);
		return $C->root(n: $n, all_roots: $all_roots, rectangular: true);
	}

	public function roots($n) {
		return $this->root(n: $n, all_roots: true);
	}

	public function pow($n) {
		if ($this->empty()) {return new self($n? 0: 1);}
		$C = new (self::T_POLAR)($this);
		return $C->pow(n: $n, rectangular: true);
	}

	public function powI($n) {
		$C = new (self::T_POLAR)($this);
		return $C->powI(n: $n, rectangular: true);
	}

	public function exp() {
		// exponential function of e -> eⁿ -> eˣ⁺ⁱʸ
		// where n is ($this->value)
		// eˣ⁺ⁱʸ = eˣ*cos(y) + i*eˣ*sin(y)
		$c = clone $this;
		$scalar_exp = Math::exp($c->real);
		$real = $scalar_exp->multiply(Math::cos($c->imaginary));
		$imaginary = new Imaginary($scalar_exp->multiply(Math::sin($c->imaginary))->value);
		return new self($real, $imaginary);
	}

	public function ln() {
		// z = r * e**iφ
		// Ln(z) = ln(r) + iφ
		return new self(Math::ln($this->abs()), new Imaginary($this->phase()));
	}

	public function empty(): bool {
		return ($this->value['real']->empty() && $this->value['imaginary']->empty());
	}

	public function isEqual($y): bool {
		// if (Delegator::getType($y)!=self::class) return false;
		$t = Delegator::getType($y);
		if ($t==self::T_POLAR) {
			$y = $y->toRectangular();
		} else if ($t!=self::class) {
			return false;
		}
		return ($this->value['real']->isEqual($y->value['real']) && $this->value['imaginary']->isEqual($y->value['imaginary']));
	}

	public function isNear($y): bool {
		$t = Delegator::getType($y);
		if ($t==self::T_POLAR) {
			$y = $y->toRectangular();
		} else if ($t!=self::class) {
			return false;
		}
		// return (Math::compare($this->value['real'], '==', $y->value['real']) && Math::compare($this->value['imaginary'], '==', $y->value['imaginary']));
		return ($this->value['real']->isNear($y->value['real']) && $this->value['imaginary']->isNear($y->value['imaginary']));
	}
}
?>