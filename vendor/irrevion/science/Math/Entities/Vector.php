<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;

class Vector extends Scalar implements Entity, \Iterator, \ArrayAccess, \Countable {
	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';
	private const T_MATRIX = 'irrevion\science\Math\Entities\Matrix';
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
		// equivalent to finding diagonal end point coords of parallelogram formed by two vectors placed at 0 point at cartegian coordinate system
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
		// equivalent to finding vector as diagonal of parallelogram of vector and inverted vector
		// equivalent to finding vector coords subtracting its initial coords
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

	// scale vector using scalar scalarMultiply() (not scalar product!)
	// dot product ·→ aliases is dotProduct(), scalarProduct(), innerProduct(), dot() ***exclude scalarProduct() to avoid disambiquity
	// cross product ⨯→ aliases is multiply(), crossProduct(), vectorProduct()
	// direct product ⊗→ (kroneker product with transponed matrix) directProduct()
	// Kronecker product ⊗→ aliases is kroneckerProduct, tensorProduct(), matrixDirectProduct()

	public function dotProduct($y) {
		// In mathematics, the dot product or scalar product is an algebraic operation that takes two equal-length sequences of numbers (usually coordinate vectors), and returns a single number.
		// Algebraically, the dot product is the sum of the products of the corresponding entries of the two sequences of numbers.
		// Geometrically, it is the product of the Euclidean magnitudes of the two vectors and the cosine of the angle between them.

		// These definitions are equivalent when using Cartesian coordinates:
		// →a · →b = ∑ (î₁î₂, ĵ₁ĵ₂, …, k₁k₂) ⇔ →a · →b = |a||b|cos(θ)
		// θ is an angle between a & b
		// cos(θ) is x/r = adjacent / hipotenuse
		// assuming x is a (adjacent) and r is b (hipotenuse), projection of b to a will be hipotenuse * (adjacent / hipotenuse) = |b|*cos(θ) = b'
		// projection of a to b is |a|*cos(θ) = a'
		// so, basically, scalar product of two vectors is magnitude(a) times projection(b to a) => |a| * b'
		// cos(θ) = b' / |b| = ( |b| * (a' / |a|) ) / |b| = a' / |a|
		// |b|cos(θ) = |b| * ( a' / |a| )
		// →a · →b = |a| * |b| * ( a' / |a| ) = |a||b|a' / |a| = |b|*a' ⇔ |a|*b'
		// a' = ( →a · →b ) / |b| = →a · →b₁ where →b₁ is Unit vector of b

		// any vector can be presented as a sum of unary vectors i, j, k, l, m, ... each multiplied by scalar koefficient
		// →a = [X, Y, Z, W, U, ...] = X*→i + Y*→j + Z*→k + W*→l + U*→m + ...
		// →b = Oi, Pj, Qk, Rl, Sm, ... = [O, P, Q, R, S, ...]
		// since scalar product of two vectors is magnitude(a) times projection(b to a)
		// →a · →b = |a||b|cos(θ)
		// lets get →a vector components by multiplying →a · →i , considering |a||i|cos(φî) = |a|*1*cos(φî) = |a|cos(φî) = a'î = X
		// (→a · →i + →a · →j + ...) = ∑ (X, Y, Z, W, U, ...) = →a · →basis
		// lets get →b vector components by multiplying →b · →i , considering |b||i|cos(γî) = |b|*1*cos(γî) = |b|cos(γî) = b'î = O
		// (→b · →i + →b · →j + ...) = ∑ (O, P, Q, R, S, ...) = →b · →basis
		// →a · →b · →basis = (→a · →b · →i + →a · →b · →j + ...) = (a'î * b'î + a'î * b'î + ...) = (XO + YP + ZQ + ...)

		// https://en.wikipedia.org/wiki/Dot_product
		// https://mathworld.wolfram.com/DotProduct.html

		$n = $this->count();
		if (empty($n)) {return 0;}
		if (Delegator::getType($y)!=self::class) {
			$y = new self($y, $this->inner_type, $n);
		}
		$y = $y->toArray();
		$x = $this->value;
		$z = Delegator::wrap(0);

		foreach ($x as $i=>$v) {
			$z = $z->add($v->multiply($y[$i]));
		}

		return $z;
	}
	public function innerProduct(...$args) {return $this->dotProduct(...$args);}
	public function dot(...$args) {return $this->dotProduct(...$args);}

	public function multiply($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		$x = $this->toArray();
		$y = $y->toArray();
		$z = [];

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
		return null;
	}

	public function transpose() {
		$z = [];
		$n = $this->count();
		if ($n) {
			foreach ($this->value as $i=>$v) {
				$z[$i][0] = $v;
			}
		}
		return Delegator::wrap($z, self::T_MATRIX);
	}

	public function invert() {
		return null;
	}

	public function magnitude() {
		// equivalent to finding vector`s absolute length
		$magnitude = 0;
		if ($this->length) {
			foreach ($this->value as $n) {
				if (Delegator::isEntity($this->inner_type)) {
					$magnitude+=Math.pow($n, 2)->toNumber();
				} else {
					$magnitude+=Math.pow($n, 2);
				}
			}
			$magnitude = Math::sqrt($magnitude);
		}
		return $magnitude;
	}

	public function abs() {
		$magnitude = $this->magnitude();
		return Delegator::wrap($magnitude, self::T_SCALAR);
	}

	public function empty() {
		return ($this->length==0);
	}

	// methods to comply interface \Iterator

	public function current(): mixed {
		return (isset($this->value[$this->pointer])? $this->value[$this->pointer]: null);
	}

	public function key(): mixed {
		return $this->pointer;
	}

	public function next(): void {
		$this->pointer++;
	}

	public function rewind(): void {
		$this->pointer = 0;
	}

	public function valid(): bool {
		return isset($this->value[$this->pointer]);
	}

	// methods to comply interface \ArrayAccess

	public function offsetExists($offset): bool {
		return isset($this->value[$offset]);
	}

	public function offsetGet($offset): mixed {
		return (isset($this->value[$offset])? $this->value[$offset]: null);
	}

	public function offsetSet($offset, $value): void {
		// throw new \Error('Immutable object');
		$type = Delegator::getType($value);
		if ($type!=$this->inner_type) {
			throw new \Error('Type mismatch: '.$this->inner_type.' expected');
		}
		$this->value[$offset] = $value;
		$this->length = count($this->value);
	}

	public function offsetUnset($offset): void {
		// throw new \Error('Immutable object');
		unset($this->value[$offset]);
		$this->length = count($this->value);
	}

	// methods to comply interface \Countable

	public function count(): int {
		$n = count($this->value);
		$this->length = $n;
		return $this->length;
	}
}
?>