<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\{Scalar, Imaginary, QuaternionComponent, Complex, Vector};

class Quaternion extends Complex {
	private const T_SCALAR = __NAMESPACE__.'\Scalar';
	private const T_IMAGINARY = __NAMESPACE__.'\Imaginary';
	private const T_QUATERNION_COMPONENT = __NAMESPACE__.'\QuaternionComponent';
	private const T_COMPLEX = __NAMESPACE__.'\Complex';
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
			$this->value['vector'] = new (self::T_VECTOR)([], self::T_QUATERNION_COMPONENT, 3);
			return;
		} else if ($t==self::T_IMAGINARY) {
			throw new \Error("Not implemented yet");
		} else if ($t==self::T_QUATERNION_COMPONENT) {
			throw new \Error("Not implemented yet");
		} else if ($t==self::T_COMPLEX) {
			throw new \Error("Not implemented yet");
		} else if ($t==self::T_VECTOR) {
			throw new \Error("Not implemented yet");
		} else if ($t==self::class) {
			throw new \Error("Not implemented yet");
		}
		throw new \Error("Unsupported argument type ( $t )");
	}
}

?>