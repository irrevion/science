<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\{Scalar, Imaginary, QuaternionComponent, Complex, ComplexPolar, Vector};

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

	public function __construct($q) {
		$t = Delegator::getType($q);
		if ($t==self::T_SCALAR) {
			$this->value['scalar'] = $q;
			$this->value['vector'] = self::V();
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

	public function multiply($y, $method='GEOMETRIC') {
		$x = clone $this;

		$t = Delegator::getType($y);
		if ($t!=self::class) {
			if (in_array($t, [self::T_SCALAR, self::T_IMAGINARY, self::T_QUATERNION_COMPONENT, self::T_COMPLEX, self::T_VECTOR, 'array'])) {
				$y = new self($y);
			} else {
				throw new \Error('Invalid argument type '.$t);
			}
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
		if ($method=='ALGEBRAIC') {
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

	public function add($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		$z = clone $this;
		$z->value['scalar'] = $this->value['scalar']->add($y->value['scalar']);
		$z->value['vector'] = $this->value['vector']->add($y->value['vector']);
		return $z;
	}
}

?>