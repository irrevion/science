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

	public function __toString() {
		return "[{$this->value['scalar']} + {$this->value['vector'][0]} + {$this->value['vector'][1]} + {$this->value['vector'][2]}]";
	}

	public function real() {return $this->value['scalar'];}
	public function i() {return $this->value['vector'][0];}
	public function j() {return $this->value['vector'][1];}
	public function k() {return $this->value['vector'][2];}

	public function multiply($y) {
		$x = clone $this;

		$t = Delegator::getType($y);
		if ($t!=self::class) {
			if (in_array($t, [self::T_SCALAR, self::T_IMAGINARY, self::T_QUATERNION_COMPONENT, self::T_COMPLEX, self::T_VECTOR, 'array'])) {
				$y = new self($y);
			} else {
				throw new \Error('Invalid argument type '.$t);
			}
		}

		if ($x->value['vector']->empty() && $y->value['scalar']->empty()) {
			$Vz = $y->value['vector']->multiply($x->value['scalar']);
			return new self($Vz);
		}

		throw new \Error('Not implemented yet');
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