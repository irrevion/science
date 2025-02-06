<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Entities\{Scalar, Imaginary, QuaternionComponent, Complex, ComplexPolar, Vector};


/**
 * @property \irrevion\science\Math\Entities\Scalar $scalar
 * @property \irrevion\science\Math\Entities\Vector $vector
 * @property \irrevion\science\Math\Entities\Scalar $real
 * @property \irrevion\science\Math\Entities\Vector $imaginary
 * @property \irrevion\science\Math\Entities\Scalar $i
 * @property \irrevion\science\Math\Entities\Scalar $j
 * @property \irrevion\science\Math\Entities\Scalar $k
 */
class Quaternion extends Complex {
	private const T_SCALAR = __NAMESPACE__.'\Scalar';
	private const T_IMAGINARY = __NAMESPACE__.'\Imaginary';
	private const T_QUATERNION_COMPONENT = __NAMESPACE__.'\QuaternionComponent';
	private const T_COMPLEX = __NAMESPACE__.'\Complex';
	private const T_COMPLEX_POLAR = __NAMESPACE__.'\ComplexPolar';
	private const T_VECTOR = __NAMESPACE__.'\Vector';
	private const T_MATRIX = 'irrevion\science\Math\Transformations\Matrix';

	public $value = [
		'scalar' => null,
		'vector' => null
	];
	public $subset_of = [
		__NAMESPACE__.'\Quaternion'
	];
	private $magnitude = 0;

	public function __construct($q, $v=0) {
		if (is_numeric($q)) $q = Delegator::wrap($q);
		$t = Delegator::getType($q);
		if ($t==self::T_SCALAR) {
			$this->value['scalar'] = $q;
			$this->value['vector'] = (empty($v)? self::V(): self::V($v[0]->value, $v[1]->value, $v[2]->value));
			return;
		} else if ($t==self::T_IMAGINARY) {
			$this->value['scalar'] = Delegator::wrap(0);
			$this->value['vector'] = self::V($q);
			return;
		} else if ($t==self::T_QUATERNION_COMPONENT) {
			$this->value['scalar'] = Delegator::wrap(0);
			$this->value['vector'] = self::V(...[$q->symbol => $q->value]);
			return;
		} else if ($t==self::T_COMPLEX) {
			$this->value['scalar'] = $q->real;
			$this->value['vector'] = self::V($q->imaginary);
			return;
		} else if ($t==self::T_COMPLEX_POLAR) {
			$q = $q->toRectangular();
			$this->value['scalar'] = $q->real;
			$this->value['vector'] = self::V($q->imaginary);
			return;
		} else if ($t==self::T_VECTOR) {
			if ($q->inner_type!==self::T_QUATERNION_COMPONENT) {throw new \Error('Vector components type is invalid');}
			if ($q->length!==3) {throw new \Error('Vector length is invalid');}
			if ($q[0]->symbol.$q[1]->symbol.$q[2]->symbol!='ijk') {throw new \Error('Vector components is a mess');}
			$this->value['scalar'] = Delegator::wrap(0);
			$this->value['vector'] = $q;
			return;
		} else if ($t==self::class) {
			$this->value['scalar'] = clone $q->value['scalar'];
			$this->value['vector'] = clone $q->value['vector'];
			return;
		} else if ($t=='array') {
			if (count($q)!==4) {throw new \Error('Invalid number of components');}
			$this->value['scalar'] = Delegator::wrap($q[0]);
			$this->value['vector'] = self::V($q[1], $q[2], $q[3]);
			return;
		}
		throw new \Error("Unsupported argument type ( $t )");
	}

	protected static function V($i=0, $j=0, $k=0) {
		return new Vector([
			new QuaternionComponent($i, 'i'),
			new QuaternionComponent($j, 'j'),
			new QuaternionComponent($k, 'k'),
		], self::T_QUATERNION_COMPONENT);
	}

	public static function fromComponents($scalar, $vector) {
		return new self([$scalar->value, $vector[0]->value, $vector[1]->value, $vector[2]->value]);
	}

	public function __toString() {
		return "[{$this->value['scalar']} + {$this->value['vector'][0]} + {$this->value['vector'][1]} + {$this->value['vector'][2]}]";
	}

	public function toNumber() {
		return $this->abs(nowrap: true);
	}

	public function toArray() {
		return [
			'scalar' => $this->real->toNumber(),
			'vector' => $this->vector->toArray()
		];
	}

	public function toVector() {
		return new Vector([$this->real, $this->i, $this->j, $this->k]);
	}

	public function toPolar() {
		// $i = new Imaginary($this->abs(nowrap: true));
		$i = new Imaginary($this->i->value);
		list($r, $phi) = Math::rectangular2polar($this->real, $i);
		return new ComplexPolar([
			'radius' => $r,
			'phase' => $phi
		]);
	}

	public function toComplex() {
		// return new Complex($this->real, new Imaginary($this->abs(nowrap: true)));
		return new Complex($this->real, new Imaginary($this->i->value));
	}

	public function real() {return $this->value['scalar'];}
	public function i() {return $this->value['vector'][0];}
	public function j() {return $this->value['vector'][1];}
	public function k() {return $this->value['vector'][2];}

	public function __get($property) {
		if (isset($this->$property)) {
			return $this->$property;
		} else if (in_array($property, ['real', 'scalar'])) {
			return $this->value['scalar'];
		} else if (in_array($property, ['vector', 'imaginary'])) {
			return $this->value['vector']->map(fn($v) => new Scalar($v->value));
			// all geometric formulas treat vector components as ordinary coordinates, not imaginary entities
			// so if you need original ijk components use $this->value['vector'], otherwise use $this->vector
		} else if (in_array($property, ['i', 'j', 'k'])) {
			return $this->$property()->toScalar();
		}
		return null;
	}

	public function isQuaternion() {
		return ($this::class==self::class);
	}

	public function multiply($y, $method='ALGEBRAIC') {
		$x = clone $this;

		$t = Delegator::getType($y);
		if ($t!=self::class) {
			//if (in_array($t, [self::T_SCALAR, self::T_IMAGINARY, self::T_QUATERNION_COMPONENT, self::T_COMPLEX, self::T_VECTOR, 'array', 'int', 'double', 'float'])) {
				$y = new self($y);
			//} else {
			//	throw new \Error('Invalid argument type '.$t);
			//}
		}

		// ( a , 0 ) ( b , 0 ) = ( a b , 0 )
		// or, algebraically
		// (a+0i+0j+0k) * (b+0i+0j+0k) = ab
		if ($x->value['vector']->empty() && $y->value['vector']->empty()) {
			$z = $x->value['scalar']->multiply($y->value['scalar']);
			return new self($z);
		}

		// ( a , 0 ) ( 0 , v → ) = ( 0 , v → ) ( a , 0 ) = ( 0 , a v → )
		// or, algebraically
		// (a+0i+0j+0k) * (0+bi+cj+dk) = 0+abi+acj+adk = 0+Va
		if ($x->value['vector']->empty() && $y->value['scalar']->empty()) {
			$Vz = $y->value['vector']->multiply($x->value['scalar']);
			return new self($Vz);
		}

		// ( 0 , u → ) ( 0 , v → ) = ( − u → ⋅ v → , u → × v → )
		// or, algebraically
		// (0+bi+cj+dk)*(0+xi+yj+zk) = bxi**2+byij+bzik+cxji+cyj**2+czjk+dxki+dykj+dzk**2 = -bx+byk-bzj-cxk-cy+czi+dxj-dyi-dz =
		// = (-bx-cy-dz)+(cz-dy)i+(-bz+dx)j+(by-cx)k
		// Cross product via determinant is = (a₁b₂ - b₁a₂) - (a₀b₂ - b₀a₂) + (a₀b₁ - b₀a₁) = (cz-dy)i+(-bz+dx)k+(by-cx)k
		// so we can see imaginary part identical to cross product and scalar is dot product of inverted vector u to v
		if ($x->value['scalar']->empty() && $y->value['scalar']->empty()) {
			// $Qz = clone $x;
			$a = $x->vector->negative()->dot($y->vector);
			$v = $x->vector->x($y->vector);
			// return new self($Qz);
			return self::fromComponents($a, $v);
		}

		// ( a, →u ) ( b, →v ) = ( ( ab − ( →u ⋅ →v ) ), ( a →v + b →u + ( →u × →v ) ) )
		// or, algebraically
		// (a+bi+cj+dk)*(w+xi+yj+zk) = aw+axi+ayj+azk+bwi+bxi**2+byij+bzik+cwj+cxji+cyj**2+czjk+dwk+dxki+dykj+dzk**2 =
		// = (aw-bx-cy-dz)+(ax+bw+cz-dy)i+(ay-bz+cw+dx)j+(az+by-cx+dw)k
		// = ( {aw} - {bx+cy+dz} ) + ( {(ax+bw)i+(ay+cw)j+(az+dw)k} + {(cz-dy)i+(-bz+dx)k+(by-cx)k} )
		// = ( {scalar} - {dot} ) + ( {(ax)i+(ay)j+(az)k} + {(bw)i+(cw)j+(dw)k} + {cross} )
		// = ( {scalar} - {dot} ) + ( {v.factor(a)} + {u.factor(w)} + {cross} )
		if ($method=='ALGEBRAIC') { // 1.5389424468297 times faster then geometric
			return new self([
				($x->real->multiply($y->real)
					->subtract($x->i->multiply($y->i))
					->subtract($x->j->multiply($y->j))
					->subtract($x->k->multiply($y->k))
				)->toNumber(),
				($x->real->multiply($y->i)
					->add($x->i->multiply($y->real))
					->add($x->j->multiply($y->k))
					->subtract($x->k->multiply($y->j))
				)->toNumber(),
				($x->real->multiply($y->j)
					->subtract($x->i->multiply($y->k))
					->add($x->j->multiply($y->real))
					->add($x->k->multiply($y->i))
				)->toNumber(),
				($x->real->multiply($y->k)
					->add($x->i->multiply($y->j))
					->subtract($x->j->multiply($y->i))
					->add($x->k->multiply($y->real))
				)->toNumber()
			]);
		} else if ($method=='GEOMETRIC') {
			$a = $x->real->multiply($y->real)->subtract($x->vector->dot($y->vector));
			$v = $y->vector->multiply($x->real)->add($x->vector->multiply($y->real))->add($x->vector->x($y->vector));
			// return new self([$a, ...$v]);
			return self::fromComponents($a, $v);
		} else {
			throw new \Error('Such a method ('.$method.') is not implemented');
		}
	}

	public function methodPowNaturalMultiply($n) {
		if (!Math::isNatural($n)) {
			throw new \Error('Only natural exponent is supported.');
		}
		$n = (Delegator::isEntity($n)? $n->toNumber(): $n);
		if ($n==0) {return new self(1);}
		if ($n==1) {return new self($this);}
		$res = $this;
		$count = 1;
		while ($count<$n) {
			$res = $res->multiply($this);
			$count++;
		}
		return $res;
	}

	public function pow($n) {
		return $this->methodPowNaturalMultiply($n);
	}

	public function powI($n) {
		throw new \Error('Not implemented yet');
	}

	public function root($n=2, $all_roots=false) {
		throw new \Error('Not implemented yet');
	}

	public function roots($n) {
		throw new \Error('Not implemented yet');
	}

	public function exp() {
		throw new \Error('Not implemented yet');
		// exponential function of e -> eⁿ -> eᵃ⁺ᵇⁱ⁺ᶜʲ⁺ᵈᵏ
		$c = $this->toRectangular();
		$scalar_exp = Math::exp($c->real);
		$real = $scalar_exp->multiply(Math::cos($c->imaginary));
		$imaginary = new Imaginary($scalar_exp->multiply(Math::sin($c->imaginary))->value);
		$result = new Complex($real, $imaginary);
		return ($rectangular? $result: $result->toPolar());
	}

	public function divide($y) {
		// if (Delegator::getType($y)!=self::class) $y = new self($y); // avoid self, it causes problems when using parent methods in chilld classes (creates parent instance instead of self)
		if (Delegator::getType($y)!=$this::class) $y = new ($this::class)($y);
		return $this->multiply($y->reciprocal());
	}

	public function reciprocal() {
		// Q_reciprocal = Q_conjugate / R_magnitude**2
		$Q_reciprocal = $this->conjugate()->multiply(Math::pow($this->magnitude(), -2));
		return $Q_reciprocal;
	}

	public function conjugate() {
		return new ($this::class)($this->real, $this->vector->negative());
	}

	public function invert() {
		return new ($this::class)($this->real->negative(), $this->vector->negative());
	}

	public function add($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		$z = clone $this;
		$z->value['scalar'] = $this->value['scalar']->add($y->value['scalar']);
		$z->value['vector'] = $this->value['vector']->add($y->value['vector']);
		return $z;
	}

	public function subtract($y) {
		if (Delegator::getType($y)!=$this::class) $y = new ($this::class)($y);
		$y = $y->negative($y);
		return $this->add($y);
	}

	public function magnitude() {
		return $this->abs();
	}

	public function abs($nowrap=false) {
		if (empty($this->magnitude)) {
			$abs = Math::sqrt($this->real->value**2 + $this->i->value**2 + $this->j->value**2 + $this->k->value**2);
			$this->magnitude = $abs;
		} else {
			$abs =$this->magnitude;
		}
		return ($nowrap? $abs: Delegator::wrap($abs));
	}

	public function empty(): bool {
		return ($this->real->empty() && $this->i->empty() && $this->j->empty() && $this->k->empty());
	}

	public function isEqual($y): bool {
		if (Delegator::getType($y)!=$this::class) return false;
		return ($this->value['scalar']->isEqual($y->value['scalar']) && $this->value['vector']->isEqual($y->value['vector']));
	}

	public function isNear($y): bool {
		if (Delegator::getType($y)!=$this::class) return false;
		return ($this->value['scalar']->isNear($y->value['scalar']) && $this->value['vector']->isNear($y->value['vector']));
	}

	public function isNaN(): bool {
		return ($this->scalar->isNaN() || $this->i->isNaN() || $this->j->isNaN() || $this->k->isNaN());
	}
}

?>