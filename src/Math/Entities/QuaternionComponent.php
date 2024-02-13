<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Entities\{Scalar, Imaginary, Complex, Quaternion, Vector};

class QuaternionComponent extends Imaginary implements Entity {
	private const T_SCALAR = __NAMESPACE__.'\Scalar';
	private const T_IMAGINARY = __NAMESPACE__.'\Imaginary';
	private const T_COMPLEX = __NAMESPACE__.'\Complex';
	private const T_QUATERNION = __NAMESPACE__.'\Quaternion';
	private const T_VECTOR = __NAMESPACE__.'\Vector';
	private const T_MATRIX = 'irrevion\science\Math\Transformations\Matrix';

	// i² = j² = k² = ijk = -1
	// https://en.wikipedia.org/wiki/William_Rowan_Hamilton
	private $multiplication_rules = [
		'1' => ['1' => 1, 'i' => 'i', 'j' => 'j', 'k' => 'k'],
		'i' => ['1' => 'i', 'i' => -1, 'j' => 'k', 'k' => '-j'], // so, as we can see it is right-handed multiplication if [i] looks left, [j] looks up and [k] looks to our face, sign of multiplication result is the same as direction of fingers folding
		'j' => ['1' => 'j', 'i' => '-k', 'j' => -1, 'k' => 'i'],
		'k' => ['1' => 'k', 'i' => 'j', 'j' => '-i', 'k' => -1]
	];

	public $value;
	public $symbol = 'i';
	public $subset_of = [
		// __NAMESPACE__.'\QuaternionComponent',
		__NAMESPACE__.'\Quaternion'
	];

	public function __construct($coefficient=1, $symbol='i') {
		parent::__construct($coefficient);

		if (!in_array($symbol, ['i', 'j', 'k'])) {
			throw new \Error('Only i, j, k basis symbols allowed');
		}
		$this->symbol = $symbol;
	}

	public function __toString() {
		return "{$this->value}{$this->symbol}";
	}

	public function isQuaternionComponent() {
		return ($this::class==self::class);
	}

	public function rule($symbol='i') {
		if (!in_array($symbol, ['i', 'j', 'k'])) {
			throw new \Error('Only i, j, k basis symbols allowed');
		}
		return $this->multiplication_rules[$this->symbol][$symbol];
	}

	public function applyRule($transforms_to) {
		if (is_numeric($transforms_to)) {
			return new (self::T_SCALAR)($this->value * $transforms_to);
		}
		$val = $this->value;
		if ($transforms_to[0]=='-') {
			$val*= -1;
			$transforms_to = substr($transforms_to, 1);
		}
		$sym = $transforms_to;
		return new self($val, $sym);
	}

	public function multiply($y) {
		$t = Delegator::getType($y);
		if ($t==self::T_IMAGINARY) {
			$y = new self($y, 'i');
			$t = self::class;
		}
		if ($t==self::class) {
			$transforms_to = $this->rule($y->symbol);
			$z = $this->applyRule($transforms_to);
			$z->value*=$y->value;
			return $z;
		} else if (in_array($t, $this->subset_of)) {
			return Delegator::delegate('multiply', $this, $y);
		}

		$i = parent::multiply($y);
		return new self($i, $this->symbol);
	}

	public function divide($y) {
		$t = Delegator::getType($y);
		if ($t==self::T_IMAGINARY) {
			$y = new self($y, 'i');
			$t = self::class;
		}
		if ($t==self::class) {
			if ($this->symbol==$y->symbol) { // cancels out
				return new (Scalar::class)($this->value / $y->value);
			} else {
				// j/k = ji/ki = -kk/jk = 1/i
				// j/k = jj/kj = -1/-i = 1/i
				// and from Imaginary class we know that
				// a / bi = ai / bi^2 = ai / -b = ( -a / b ) * i
				$transforms_to = $this->rule($y->symbol);
				$z = clone $this;
				$z->value = $this->value / $y->value;
				$z = $z->applyRule($transforms_to)->negative();
				return $z;
			}
		} else if ($t==Scalar::class) {
			$z = clone $this;
			$z->value = $this->value / $y->value;
			return $z;
		} else if (in_array($t, $this->subset_of)) {
			return Delegator::delegate('divide', $this, $y);
		}

		throw new \Error('Unsupported argument type');
	}

	public function add($y) {
		$t = Delegator::getType($y);
		if ($t!=self::class) {
			if (in_array($t, $this->subset_of)) {
				return Delegator::delegate('add', $this, $y); // Quaternion will do
			}
			throw new \Error('Quaternion component addition defined only for same type objects');
		}
		if ($y->symbol==$this->symbol) {
			return new self(($this->value + $y->value), $this->symbol);
		} else {
			return Delegator::delegate('add', $this, $y); // Quaternion will do
		}
	}

	public function subtract($y) {
		if (is_numeric($y)) {
			throw new \TypeError("Built-in types casting not allowed for imaginary numbers due to ambiguity. Explicitly convert either to Scalar or to Imaginary.");
		} else if (is_object($y)) {
			if ($y::class==self::class) {
				return $this->add($y->negative());
			} else if (Delegator::isEntity($y)) {
				return Delegator::delegate('subtract', $this, $y);
			}
		}
		throw new \Error('Unsupported argument type');
	}

	public function abs($nowrap=false) {
		$abs = abs($this->value);
		return ($nowrap? $abs: Delegator::wrap($abs));
	}

	public function invert() {
		return $this->multiply(new Scalar(-1));
	}

	public function empty(): bool {
		return ($this->value==0);
	}

	public function isEqual($y): bool {
		if (Delegator::getType($y)!=self::class) return false;
		return (($this->value==$y->value) && ($this->symbol==$y->symbol));
	}

	public function isNear($y): bool {
		if (Delegator::getType($y)!=self::class) return false;
		if ($this->symbol!=$y->symbol) return false;
		return Math::compare($this->value, '==', $y->value);
	}
}

?>