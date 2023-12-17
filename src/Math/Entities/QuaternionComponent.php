<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;
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
		__NAMESPACE__.'\QuaternionComponent',
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
		}

		$i = parent::multiply($y);
		return new self($i, $this->symbol);
	}

	public function empty(): bool {
		return ($this->value==0);
	}
}

?>