<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\Scalar;
use irrevion\science\Math\Entities\Imaginary;
use irrevion\science\Math\Entities\Complex;
use irrevion\science\Math\Operations\Delegator;

class ComplexPolar extends Complex implements Entity {
	public const SPACE = 'euclidean';
	public const COORDINATE_SYSTEM = 'polar';
	public const DIMENSIONS_NUMBER = '2';

	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';
	private const T_IMAGINARY = 'irrevion\science\Math\Entities\Imaginary';
	private const T_COMPLEX = 'irrevion\science\Math\Entities\Complex';

	public $value;
	public $subset_of = [
		'irrevion\science\Math\Entities\ComplexPolar'
	];

	public function __construct($r = 0, $phi = 0) {
		$this->value = [];
		$rt = Delegator::getType($r);
		if (Delegator::isEntity($r)) {
			if ($rt==self::class) {
				$this->value['radius'] = clone $r->r;
				$this->value['phase'] = clone $r->phi;
				return;
			} else if ($rt==self::T_COMPLEX) {
				$c = $r->toArray();
				list($r, $phi) = Math::rectangular2polar($c['real'], $c['imaginary']);
				$this->value['radius'] = Delegator::wrap($r);
				$this->value['phase'] = Delegator::wrap($phi);
				return;
			} else if ($rt==self::T_SCALAR) {
				$this->value['radius'] = clone $r;
			} else {
				//$this->value['radius'] = Delegator::wrap($r->toNumber());
				throw new \TypeError("Unrecognized type of radius argument ( {$r} :: {$rt} )");
			}
		} else {
			if (is_array($r)) {
				list($r, $phi) = Math::polar_absolute($r['radius'], $r['phase']);
				$this->value['radius'] = Delegator::wrap($r);
				$this->value['phase'] = Delegator::wrap($phi);
				return;
			} else if (is_numeric($r)) {
				$this->value['radius'] = Delegator::wrap($r);
			} else {
				throw new \TypeError("Unrecognized type of radius argument ( {$r} :: {$rt} )");
			}
		}
		$phi_type = Delegator::getType($phi);
		if ($phi_type==self::T_SCALAR) {
			$this->value['phase'] = clone $phi;
		} else if (is_numeric($r)) {
			$this->value['phase'] = Delegator::wrap($phi);
		} else {
			throw new \TypeError("Unrecognized type of phase argument ( {$phi} :: {$phi_type} )");
		}

		list($r, $phi) = Math::polar_absolute($this->value['radius']->toNumber(), $this->value['phase']->toNumber());
		$this->value['radius']->value = $r;
		$this->value['phase']->value = $phi;
	}

	public function __get($property) {
		if (isset($this->$property)) {
			return $this->$property;
		} else if (array_key_exists($property, $this->value)) {
			return $this->value[$property];
		} else if ($property=='r') {
			return $this->value['radius'];
		} else if ($property=='phi') {
			return $this->value['phase'];
		}
		return null;
	}

	public function __toString() {
		return "[{$this->r}, φ ".($this->phi->toNumber()/Math::PI)."π RAD]";
	}

	public function toNumber() {
		return $this->radius->toNumber();
	}

	public function toArray() {
		return [
			'radius' => $this->r->toNumber(),
			'phase' => $this->phi->toNumber()
		];
	}

	public function toRectangular() {
		list($x, $y) = Math::polar2rectangular($this->r->toNumber(), $this->phi->toNumber());
		return Delegator::wrap([
			'real' => $x,
			'imaginary' => $y
		], self::T_COMPLEX);
	}

	public function isComplexPolar() {
		return ($this::class==self::class);
	}

	public function add($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		$x = clone $this;

		$is_outer_parallelogram = false;
		$phi_angle = $x->phi->toNumber(); // Rx angle (0, π, 2π is real axis; π/2, 3π/2, -π/2 is imaginary axis)
		$theta_angle = $y->phi->toNumber(); // Ry angle
		$rx = $x->r->toNumber();
		$ry = $y->r->toNumber();

		$gamma_angle = Math::abs($theta_angle - $phi_angle); // angle between phi and theta ( Rx and Ry )
		if ($gamma_angle > Math::PI) {
			$is_outer_parallelogram = true;
			$gamma_angle = Math::TAU - $gamma_angle;
			//print "γ $gamma_angle = τ ".Math::TAU." - γ $gamma_angle;\n";
			//$gamma_angle = Math::TAU - $theta_angle + $phi_angle;
			//print "γ $gamma_angle = τ ".Math::TAU." - θ $theta_angle + φ $phi_angle;\n";
			//$gamma_angle = Math::TAU - Math::abs($theta_angle - $phi_angle);
			//print "γ $gamma_angle = τ ".Math::TAU." - γ ".Math::abs($theta_angle - $phi_angle).";\n";
			// we are counting outside angle, so
			// get theta angle as the remained angle to do a loop
			// then add phi to be relative to phi instead of x axis
		}
		$sigma_angle = Math::PI - $gamma_angle; // angle of another corner of parallelogram ( Ry and Ry->Rz )
		if (($sigma_angle==0) || ($gamma_angle==0)) {
			return new self(0, 0);
		}
		//print "δ $sigma_angle = Math::PI - γ $gamma_angle;\n";
		$rz = Math::sqrt(Math::pow($rx, 2) + Math::pow($ry, 2) + ((2 * $rx * $ry) * Math::cos($gamma_angle))); // diagonal of parallelogram
		// $rz = Math::sqrt(Math::pow($rx, 2) + Math::pow($ry, 2) - ((2 * $rx * $ry) * Math::cos($sigma_angle))); // diagonal of parallelogram by sigma
		if ($phi_angle>$theta_angle) {
			list($rx, $ry) = [$ry, $rx];
			list($phi_angle, $theta_angle) = [$theta_angle, $phi_angle];
			// calculate angle to the nearest side, so swap rx and ry, their angles too
		}
		$cos_alpha = ((Math::pow($ry, 2) + Math::pow($rz, 2) - Math::pow($rx, 2)) / (2 * $ry * $rz)); // angle between Ry and Rz
		$alpha_angle = acos($cos_alpha); // angle between Ry and Rz
		//print "cos(α) = $cos_alpha;\n";
		//print "α $alpha_angle = acos((Math::pow(y $ry, 2) + Math::pow(z $rz, 2) - Math::pow(x $rx, 2)) / (2 * y $ry * z $rz));\n";
		if ($is_outer_parallelogram) {
			$beta_angle = Math::abs($theta_angle + $alpha_angle); // angle between 0 angle and Rz
		} else {
			$beta_angle = Math::abs($theta_angle - $alpha_angle); // angle between 0 angle and Rz
		}

		return new self($rz, $beta_angle);
	}

	public function subtract($y) {
		if (Delegator::getType($y)!=self::class) $y = new self($y);
		$y = $y->negative($y);
		return $this->add($y);
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
		if (($this->value['imaginary']->value==0) && ($y->value['real']->value==0)) {
			// a / bi = ai / bi^2 = ai / -b = ( -a / b ) * i
			$z = ($this->value['real']->value / $y->value['imaginary']->value) * -1;
			$z = Delegator::wrap($z, self::T_IMAGINARY);
			return $z;
		}
		// c / y = c * (1 / y)
		// (1 / y) is reciprocal
		// (1 / y) = 1 / (a + bi) = (a - bi) / (a + bi)(a - bi) = (a - bi) / ((a^2 + b^2) + (-ab + ab)i) = (a - bi) / (a^2 + b^2)
		// (a - bi) / (a^2 + b^2) = (a / (a^2 + b^2)) + (-b / (a^2 + b^2)i)
		// so, we can multiply:
		// c * (a / (a^2 + b^2)) + (-b / (a^2 + b^2)i)
		$a = $y->getReal();
		$b = $y->getImaginary();
		$denominator = (Math::pow($a, 2) + Math::pow($b, 2)); // (a / (a^2 + b^2))
		$reciprocal_real = ($a / $denominator); // (a / (a^2 + b^2))
		$reciprocal_imaginary = (($b*-1) / $denominator); // (-b / (a^2 + b^2)i)
		$reciprocal = new self($reciprocal_real, $reciprocal_imaginary);
		return $this->multiply($reciprocal);
	}

	public function reciprocal() {
		return null;
	}

	public function conjugate() {
		return new self($this->r->toNumber(), ((2 * Math::PI) - $this->phi->toNumber()));
	}

	public function invert() {
		// $x = clone $this;
		// $phi = $this->phi->toNumber();
		// $phi = $phi + (Math::PI * (($phi>Math::PI)? -1: 1));
		// $x->value['phase']->value = $phi;
		// return $x;
		$x = $this->toArray();
		$x['phase'] = $x['phase'] + (Math::PI * (($x['phase']>Math::PI)? -1: 1));
		return new self($x);
	}

	public function abs() {
		return clone $this->r;
	}

	public function empty() {
		return ($this->value['real']->empty() && $this->value['imaginary']->empty());
	}
}
?>