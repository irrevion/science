<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;

class Vector extends Scalar implements Entity, \Iterator, \ArrayAccess, \Countable {
	private const T_SCALAR = __NAMESPACE__.'\Scalar';
	private const T_MATRIX = 'irrevion\science\Math\Transformations\Matrix';
	private $pointer = 0;

	public $value;
	public $length = 0;
	public $inner_type = null;
	public $subset_of = [
		__NAMESPACE__.'\Vector',
		// __NAMESPACE__.'\Matrix',
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
		return $this->magnitude()->toNumber();
	}

	public function toArray() {
		return $this->value;
	}

	public function isVector() {
		return ($this::class==self::class);
	}

	public function pad(int $length): Vector {
		/* $x_len = $this->count();
		$arr = $this->value;
		while ($x_len<$length) {
			$arr[] = Delegator::wrap(0, $this->inner_type);
		}
		return new self($arr, $this->inner_type); */
		return new self($this->value, $this->inner_type, $length);
	}

	public function slice(int $length): Vector {
		$z = new self(array_slice($this->value, 0, $length), $this->inner_type);
		$z->count();
		return $z;
	}

	public function cutZeroTail(): Vector {
		$z = $this->value;
		// print "cutZeroTail $this \n";
		while (count($z)) {
			$v = end($z);
			if ($v===false) {break;}
			if (($v===0) || (Delegator::isEntity($v) && $v->empty())) {
				array_pop($z);
			} else {
				break;
			}
		}
		return new self($z, $this->inner_type);
	}

	public function align($y) {
		$x = clone $this;
		// print "align $x and $y \n";
		$x = $x->cutZeroTail();
		$y = $y->cutZeroTail();
		$x_len = $x->count();
		$y_len = $y->count();
		// print "$y_len!=$x_len \n";
		if ($y_len<$x_len) {
			$y = $y->pad($x_len);
		} else if ($y_len>$x_len) {
			$x = $x->pad($y_len);
		}
		return [$x, $y];
	}

	public function as($type) {
		return new self($this->value, $type);
	}

	public function add($y) {
		// equivalent to finding diagonal end point coords of parallelogram formed by two vectors placed at 0 point at cartegian coordinate system
		if (Delegator::getType($y)!=self::class) $y = new self($y, $this->inner_type, $this->length);
		$x = clone $this;
		$z = [];

		if ($y->length!=$x->length) {
			// throw new \Error('Mismatch of the vectors length');
			// print "vector add mismatch $x + $y\n";
			list($x, $y) = $x->align($y);
		}
		// print "vector add $x + $y\n";

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

	// scale vector using scalar scalarMultiply() (not scalar product!), k(), coefficient(), times(), scale()
	// dot product ·→ aliases is dotProduct(), scalarProduct(), innerProduct(), dot() ***exclude scalarProduct() to avoid ambiquity
	// Hadamard product ⊙→ aliases is multiplyElementwise(), hadamardProduct(), schurProduct()
	// cross product ⨯→ aliases is crossProduct(), vectorProduct(), cross(), x()
	// direct product ⊗→ (Kroneker product with transponed matrix) directProduct()
	// Kronecker product ⊗→ aliases is kroneckerProduct(), tensorProduct(), matrixDirectProduct()
	// exterior product is exteriorProduct();

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
	public function dot(...$args) {return $this->dotProduct(...$args);}
	// public function innerProduct(...$args) {return $this->dotProduct(...$args);} // excluded not to mess with Hermitian inner product or inner product via conjugation a.b = Conjugate[a].b
	// public function scalarProduct(...$args) {return $this->dotProduct(...$args);} // excluded not to mess with scalar multiplication

	public function multiply($y) {
		$n = $this->count();
		if (empty($n)) {
			return new self([]);
		}
		$yt = Delegator::getType($y);
		if ($yt!=self::class) {
			// if ($yt==self::T_SCALAR) {
			if (Delegator::isEntity($y) && !Delegator::implements($y, 'Traversable')) {
				return $this->k($y);
			} else {
				$y = new self($y, $this->inner_type, $n);
			}
		}
		// return $this->vectorProduct($y);
		return $this->multiplyElementwise($y);
	}

	public function multiplyElementwise(Vector $y): Vector {
		$x = clone $this;
		$y_len = $y->count();
		$x_len = $this->count();
		// if ($y_len>$x_len) {$x = $x->pad($y_len);}
		// if ($x_len>$y_len) {$y = $y->pad($x_len);}
		if ($y_len>$x_len) {$y = $y->slice($x_len);}
		if ($x_len>$y_len) {$x = $x->slice($y_len);}
		$z = [];
		if ($x->count()) {
			foreach ($x->value as $i=>$v) {
				$z[] = $v->multiply($y[$i]);
			}
		}
		$z = new self($z, $this->inner_type);
		$z = $z->cutZeroTail();
		return $z;
	}
	public function hadamardProduct(...$args) {return $this->multiplyElementwise(...$args);}
	public function schurProduct(...$args) {return $this->multiplyElementwise(...$args);}

	public function vectorProduct(Vector $y): Vector {
		$x = clone $this;
		$y_len = $y->count();
		$x_len = $x->count();
		if ($y_len!=$x_len) {
			// throw new \Error('Vector length mismatch: '.$x_len.' expected');
			if ($y_len<$x_len) {
				$y = $y->pad($x_len);
				$y_len = $y->count();
			} else {
				$x = $x->pad($y_len);
				$x_len = $x->count();
			}
		}
		if ($y_len==0) {
			// null vector
			return new self([]);
		} else if ($y_len==1) {
			// real number multiplication XXX WRONG!!! collinear vectors cross product gives zero!
			// return new self([$x->value[0]->multiply($y-value[0])]);
			return new self([0]);
		} else if ($y_len==2) {
			// 2d vector multiplication
			return $x->crossProduct2D($y);
		} else if ($y_len==3) {
			return $x->crossProduct($y);
		} else {
			throw new \Error('Vector product not implemented for '.$x_len.' dimensions');
		}
	}

	public function crossProduct2D(Vector $y): Vector {
		$y_len = $y->count();
		$x_len = $this->count();
		if ($y_len!=2) throw new \Error('Vector expected to be 3D');
		if ($x_len!=$y_len) throw new \Error('Vector length mismatch: '.$x_len.' expected');

		$determinant = [
			[$this->value[0], $this->value[1]], // [a, b]
			[$y->value[0],    $y->value[1]],    // [c, d]
		];
		// calculates as ad-bc (why?)
		// $determinant_calculated = $this->value[0]->multiply($y->value[1])->subtract($this->value[0]->multiply($y->value[1]));
		$determinant_calculated = $determinant[0][0]->multiply($determinant[1][1])->subtract($determinant[0][1]->multiply($determinant[1][0]));
		// resulting vector pointing in k direction (basis ijk) or z direction (basis xyz)
		$z = [0, 0, $determinant_calculated];
		$z = new self($z, $this->inner_type);

		// using formula |c| = |a||b|sin(θ) we can obtain angle too (just for testing)
		$x_magnitude = $this->magnitude();
		$y_magnitude = $y->magnitude();
		$z_magnitude = $z->magnitude();
		$sin_theta = $z_magnitude->divide($x_magnitude->multiply($y_magnitude));
		$theta = Math::asin($sin_theta);
		print "|c| $z_magnitude = |a| $x_magnitude * |b| $y_magnitude * sin(θ) $sin_theta \n";
		print "angle θ is $theta RAD \n";

		return $z;
	}

	public function crossProduct(Vector $y): Vector {
		// Cross product (AxB)
		// https://en.wikipedia.org/wiki/Cross_product

		//          | i  j  k  |
		// A x B =  | a₀ a₁ a₂ | = |a₁ a₂|  - |a₀ a₂|  + |a₀ a₁|
		//          | b₀ b₁ b₂ |   |b₁ b₂|i   |b₀ b₂|j   |b₀ b₁|k

		// = (a₁b₂ - b₁a₂) - (a₀b₂ - b₀a₂) + (a₀b₁ - b₀a₁)

		$y_len = $y->count();
		$x_len = $this->count();
		if ($y_len!=3) throw new \Error('Vector expected to be 3D');
		if ($x_len!=$y_len) throw new \Error('Vector length mismatch: '.$x_len.' expected');

		$z = [];
		$z[] = $this->value[1]->multiply($y[2])->subtract($this->value[2]->multiply($y[1]));
		$z[] = $this->value[0]->multiply($y[2])->subtract($this->value[2]->multiply($y[0]))->invert();
		$z[] = $this->value[0]->multiply($y[1])->subtract($this->value[1]->multiply($y[0]));

		return new self($z, $this->inner_type);
	}
	public function crossProduct3D(...$args) {return $this->crossProduct(...$args);}
	public function cross(...$args) {return $this->crossProduct(...$args);}
	public function x(...$args) {return $this->crossProduct(...$args);}

	public function k($y) {
		$z = [];
		$n = $this->count();
		if ($n) {
			foreach ($this->value as $i=>$v) {
				$z[] = $v->multiply($y);
			}
		}

		// return new self($z, Delegator::getType($z[0]));
		return new self($z, $this->inner_type);
	}
	public function coefficient(...$args) {return $this->k(...$args);}
	public function times(...$args) {return $this->k(...$args);}
	public function scale(...$args) {return $this->k(...$args);}
	public function scalarMultiply(...$args) {return $this->k(...$args);}

	public function divide($y) {
		$n = $this->count();
		if (empty($n)) {
			return new self([]);
		}
		$yt = Delegator::getType($y);
		if ($yt!=self::class) {
			if ($yt==self::T_SCALAR) {
				return $this->k($y->reciprocal());
			} else {
				$y = new self($y, $this->inner_type, $n);
			}
		}
		return $this->divideElementwise($y);
	}

	public function divideElementwise(Vector $y): Vector {
		$x = clone $this;
		$y_len = $y->count();
		$x_len = $this->count();
		if ($y_len>$x_len) {$x = $x->pad($y_len);}
		if ($x_len>$y_len) {$y = $y->pad($x_len);}
		$z = [];
		if ($x->count()) {
			foreach ($x->value as $i=>$v) {
				$z[] = $v->divide($y[$i]);
			}
		}
		$z = new self($z, $this->inner_type);
		$z = $z->cutZeroTail();
		return $z;
	}

	public function reciprocal() {
		throw new \Error('Not implemented yet');
	}

	public function conjugate() {
		throw new \Error('Not implemented yet');
	}

	public function normalize() {
		return $this->divide($this->magnitude());
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
		return $this->k(-1);
	}

	public function magnitude() {
		// equivalent to finding vector`s absolute length
		$magnitude = 0;
		if ($this->length) {
			foreach ($this->value as $n) {
				if (Delegator::isEntity($this->inner_type)) {
					$magnitude+=Math::pow($n, 2)->toNumber();
				} else {
					$magnitude+=Math::pow($n, 2);
				}
			}
			$magnitude = Math::sqrt($magnitude);
		}
		return Delegator::wrap($magnitude);
	}

	public function abs() {
		$magnitude = $this->magnitude();
		return $magnitude;
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