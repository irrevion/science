<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\{Scalar, Imaginary, Vector, Matrix};

class QuaternionComponent extends Imaginary implements Entity {
	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';
	private const T_IMAGINARY = 'irrevion\science\Math\Entities\Imaginary';
	private const T_VECTOR = 'irrevion\science\Math\Entities\Vector';
	private const T_MATRIX = 'irrevion\science\Math\Entities\Matrix';

	public $value = [
		'scalar' => null,
		'vector' => null
	];
}

?>