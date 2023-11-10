<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;

class Vector extends Scalar implements Entity, \Iterator {
	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';
	private $pointer = 0;

	public $value;
	public $length = 0;
	public $inner_type = null;
	public $subset_of = [
		'irrevion\science\Math\Entities\Vector',
		'irrevion\science\Math\Entities\Matrix',
	];

	public function __construct($array, $type=self::T_SCALAR, $pad_to_length=0) {
		$this->value = [];
		$arr_type = Delegator::getType($array);
		if (Delegator::isEntity($array)) {
			$math_object = $array;
			if ($arr_type==self::class) {
				$this->value = $math_object->toArray();
			} else if (Delegator::hasMethod($math_object, 'toVector')) {
				$this->value = $math_object->toVector()->toArray();
			} else {
				$this->value = [$math_object];
			}
		} else if (is_array($array)) {
			$this->value = $array;
		} else {
			throw new \TypeError("Unrecognized type of argument");
		}

		if ($pad_to_length) {
			$curr_length = count($this->value);
			if ($pad_to_length>$curr_length) {
				$n_elements_left = $pad_to_length-$curr_length;
				while($n_elements_left) {
					$this->value[] = ($type? Delegator::wrap(0, $type):  0);
					$n_elements_left--;
				}
			}
		}
		$this->length = count($this->value);

		if ($type) {
			$this->inner_type = $type;
			// set specified type for all elements
			foreach ($this->value as $i=>$el) {
				$this->value[$i] = Delegator::wrap($el, $type);
			}
		} else {
			if ($this->length) {
				$this->inner_type = Delegator::getType($this->value[0]);
			}
		}
	}

	public function __toString() {
		return '['.implode(', ', $this->value).']';
	}

	public function toNumber() {
		return null;
	}

	public function toArray() {
		return $this->value;
	}

	public function isVector() {
		return ($this::class==self::class);
	}

	public function add($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y, $this->inner_type, $this->length);
		$x = clone $this;
		$z = [];

		if ($y->length!=$x->length) {
			throw new \Error('Mismatch of the vectors length');
		}

		foreach ($x as $i=>$v) {
			$z[] = $v->add($y[$i]);
		}
		$z = new self($z, $this->inner_type);

		return $z;
	}

	public function subtract($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y, $this->inner_type, $this->length);
		$x = clone $this;
		$z = [];

		if ($y->length!=$x->length) {
			throw new \Error('Mismatch of the vectors length');
		}

		foreach ($x as $i=>$v) {
			$z[] = $v->subtract($y[$i]);
		}
		$z = new self($z, $this->inner_type);

		return $z;
	}

	public function multiply($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		$x = $this->toArray();
		$y = $y->toArray();
		$z = ['radius' => 0, 'phase' => 0];

		// module of resulting vector is multiplied modules of given vectors
		$z['radius'] = $x['radius'] * $y['radius'];

		// now we should calculate angle of Z
		// knowing algebraic form XY = (a+bi)(c+di) = (ac - bd) + (ad + cb)i
		// so Real part (coordinate on real axis) id (ac - bd) and Imaginary part is (ad + cb)
		// knowing that sin = y/r and cos = x/r, so x=R*cos(α) and y=R*sin(α)
		// knowing that Real = |Z|*cos(γ) and Imaginary = |Z|*sin(γ)
		// lets replace Real or Imaginary with algebraic form
		// thus for Imaginary:
		// |Z|*sin(γ) = (ad + cb) => sin(γ) = (ad + cb)/|Z|
		// replace |Z| with |X|*|Y|
		// then lets change real "a" to |X|*cos(α), "b" to |X|*sin(α), "c" to |Y|*cos(β) and "d" to |Y|*sin(β)
		// we will get
		// sin(γ) = ( |X|*cos(α) * |Y|*sin(β) + |X|*sin(α) *  |Y|*cos(β)) / |X|*|Y|
		// => sin(γ) = cos(α)*sin(β) + sin(α)*cos(β)
		// lets apply trigonometric rule sin(α ± β) = sin(α)*cos(β) ± cos(α)*sin(β)
		// and get
		// sin(γ) = sin(α + β)
		// almost the same result we will got for Real part:
		// cos(γ) = cos(α)*cos(β) - sin(α)*sin(β)
		// apply cos(α ± β) = cos(α)*cos(β) ∓ sin(α)*sin(β)
		// cos(γ) = cos(α + β)
		// that means γ = α + β
		$z['phase'] = $x['phase'] + $y['phase'];

		return new self($z);
	}

	public function divide($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		return $this->multiply($y->reciprocal());
	}

	public function reciprocal() {
		// 1/z = ž/|z|^2
		// reciprocal is conjugate divided by squared module
		// $reciprocal = $this->conjugate()->divide(Math::pow($this->r, 2));
		// to prevent infinit recursion in division method we directrly divide radius by scalar
		$conjugate = $this->conjugate();
		$r = $conjugate->r->divide(Math::pow($this->r, 2));
		$reciprocal = new self($r->toNumber(), $conjugate->phi->toNumber());
		return $reciprocal;
	}

	public function conjugate() {
		return new self($this->r->toNumber(), ((2 * Math::PI) - $this->phi->toNumber()));
	}

	public function invert() {
		$x = $this->toArray();
		$x['phase'] = $x['phase'] + (Math::PI * (($x['phase']>Math::PI)? -1: 1));
		return new self($x);
	}

	public function abs() {
		return clone $this->r;
	}

	public function empty() {
		return ($this->length==0);
	}

	// functions to comply interface \Iterator

	public function current() {
		return (isset($this->value[$this->pointer])? $this->value[$this->pointer]: null);
	}

	public function key() {
		return $this->pointer;
	}

	public function next() {
		$this->pointer++;
	}

	public function rewind() {
		$this->pointer = 0;
	}

	public function valid() {
		return isset($this->value[$this->pointer]);
	}

	// functions to comply interface \ArrayAccess

	public function offsetExists($offset) {
		return isset($this->value[$offset]);
	}

	public function offsetGet($offset) {
		return (isset($this->value[$offset])? $this->value[$offset]: null);
	}

	public function offsetSet($offset, $value) {
		throw new \Error('Immutable object');
	}

	public function offsetUnset($offset) {
		throw new \Error('Immutable object');
	}
}
?>