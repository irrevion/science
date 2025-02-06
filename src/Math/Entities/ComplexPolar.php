<?php
namespace irrevion\science\Math\Entities;

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{
	Scalar, Imaginary, Complex
};


/**
 * @property \irrevion\science\Math\Entities\Scalar $radius
 * @property \irrevion\science\Math\Entities\Scalar $r
 * @property \irrevion\science\Math\Entities\Scalar $phase
 * @property \irrevion\science\Math\Entities\Scalar $phi
 */
class ComplexPolar extends Complex implements Entity {
	public const SPACE = 'euclidean';
	public const COORDINATE_SYSTEM = 'polar';
	public const DIMENSIONS_NUMBER = '2';

	private const T_SCALAR = __NAMESPACE__.'\Scalar';
	private const T_IMAGINARY = __NAMESPACE__.'\Imaginary';
	private const T_COMPLEX = __NAMESPACE__.'\Complex';

	public $value;
	public $subset_of = [
		__NAMESPACE__.'\ComplexPolar'
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
			// we are counting outside angle, so
			// get theta angle as the remained angle to do a loop
			// then add phi to be relative to phi instead of x axis
		}
		$sigma_angle = Math::PI - $gamma_angle; // angle of another corner of parallelogram ( Ry and Ry->Rz )
		if (($sigma_angle==0) || ($gamma_angle==0)) {
			return new self(0, 0);
		}
		$rz = Math::sqrt(Math::pow($rx, 2) + Math::pow($ry, 2) + ((2 * $rx * $ry) * Math::cos($gamma_angle))); // diagonal of parallelogram
		// $rz = Math::sqrt(Math::pow($rx, 2) + Math::pow($ry, 2) - ((2 * $rx * $ry) * Math::cos($sigma_angle))); // diagonal of parallelogram by sigma
		if ($phi_angle>$theta_angle) {
			list($rx, $ry) = [$ry, $rx];
			list($phi_angle, $theta_angle) = [$theta_angle, $phi_angle];
			// calculate angle to the nearest side, so swap rx and ry, their angles too
		}
		$cos_alpha = ((Math::pow($ry, 2) + Math::pow($rz, 2) - Math::pow($rx, 2)) / (2 * $ry * $rz)); // angle between Ry and Rz
		$alpha_angle = acos($cos_alpha); // angle between Ry and Rz
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
		// so Real part (coordinate on real axis) is (ac - bd) and Imaginary part is (ad + cb)
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

	public function root($n=2, $all_roots=false, $rectangular=false) {
		if ($this->empty()) {return new ($rectangular? (Complex::class): (self::class))(0);}
		if (Delegator::isEntity($n)) {$n = $n->toNumber();}
		$roots = [];
		$r_root = Math::pow($this->r, new Fraction("1/{$n}"));
		$n_sign = Math::sign($n);
		// $n_abs = Math::abs($n);
		$n = Math::abs($n);
		$k = 0;
		while ($k<$n) {
		// while ($k<$n_abs) {
			$real = $r_root->multiply(Math::cos($this->phi->add(2*Math::PI*$k)->divide($n)));
			$imaginary = new Imaginary($r_root->multiply(Math::sin($this->phi->add(2*Math::PI*$k)->divide($n)))->toNumber());
			$C = new Complex($real, $imaginary);
			$roots[] = ($rectangular? $C: $C->toPolar());
			if (!$all_roots) break;
			$k++;
		}
		if ($n_sign==-1) {array_map(fn($r) => ((new Scalar(1))->divide($r)), $roots);}
		return ($all_roots? $roots: $roots[0]);
	}

	public function roots($n, $rectangular=false) {
		return $this->root(n: $n, all_roots: true, rectangular: $rectangular);
	}

	public function pow($n, $rectangular=false) {
		if (Delegator::isEntity($n)) {$n = $n->toNumber();}
		if ($this->empty()) {return new ($rectangular? (Complex::class): (self::class))($n? 0: 1);}
		$r = Math::pow($this->r, $n);
		$real = $r->multiply(Math::cos($this->phi->multiply($n)));
		$imaginary = new Imaginary($r->multiply(Math::sin($this->phi->multiply($n)))->toNumber());
		$C = new Complex($real, $imaginary);
		return ($rectangular? $C: $C->toPolar());
	}

	public function powI($n, $rectangular=false) {
		$exp_type = Delegator::getType($n);
		if (!in_array($exp_type, [self::T_IMAGINARY, self::T_COMPLEX, self::class])) throw new \Error('Invalid exponent type');
		if ($exp_type==self::T_IMAGINARY) $n = new Complex($n);
		if ($exp_type==self::class) $n = $n->toRectangular();

		/*
		let $this = z = [a+bi] = r(cos(φ)+i*sin(φ))
		let $n = n = [c+di] = R(cos(θ)+i*sin(θ))
		zⁿ = r**c * e**(-d*φ) * ( cos(d*ln(r)+cφ) + i*sin(d*ln(r)+cφ) )
		https://mathworld.wolfram.com/ComplexExponentiation.html

		*** How is it retrieved? ***

		zⁿ = ( e**ln(z) )**n
		let z = r * e**iφ = r * (cos(φ) + i*sin(φ))
		let n = r * e**iθ = r * (cos(θ) + i*sin(θ))
		z**(c+di) = z**c * z**id = ...

		let z**c = r**c * ( cos(c*φ) + i*sin(c*φ) ) = r**c * e**(i*c*φ) | from Moavre formulae
		... = ( r**c * (cos(c*φ) + i*sin(c*φ)) ) * z**id = ...

		let z**id = e**(ln(z)*id)
		let ln(z) = ln(r * e**iφ) = ln(r) + iφ
		let e**(ln(z)*i*d) = e**((ln(r) + iφ) * i*d) = e**(ln(r)*i*d - φ*d) = e**(-φ*d + i*ln(r)*d) = e**(-φ*d) * e**(i*ln(r)*d) = e**(-φ*d) * ( cos(ln(r)*d) + i*sin(ln(r)*d) )
		... = ( r**c * (cos(c*φ) + i*sin(c*φ)) ) * e**(-φ*d) * ( cos(ln(r)*d) + i*sin(ln(r)*d) ) = ( r**c * e**(-φ*d) * (cos(c*φ) + i*sin(c*φ)) ) * ( cos(ln(r)*d) + i*sin(ln(r)*d) ) = ...

		let sin(α+β) = sin(α)*cos(β) + cos(α)*sin(β)
		let cos(α+β) = cos(α)*cos(β) – sin(α)*sin(β)
		let (cos(α)+i*sin(α))*(cos(β)+i*sin(β)) = cos(α)*cos(β) + cos(α)*i*sin(β) + i*sin(α)*cos(β) + i*sin(α)*i*sin(β) = cos(α)*cos(β) + cos(α)*i*sin(β) + i*sin(α)*cos(β) - sin(α)*sin(β) = cos(α+β) + cos(α)*i*sin(β) + i*sin(α)*cos(β) = cos(α+β) + i(sin(α)*cos(β) + cos(α)*sin(β)) = cos(α+β) + i(sin(α+β))
		... =  r**c * e**(-φ*d) * ( cos(ln(r)*d+c*φ) + i*sin(n(r)*d+c*φ) )

		note: this version differs from wolfram.com version only by 1/2 ln( a**2 + b**2 ), which is the same as ln(r)
		*/

		$k = Math::pow($this->r, $n->real)->multiply(Math::exp($n->imaginary->toScalar()->negative()->multiply($this->phi)));
		$y = $n->imaginary->toScalar()->multiply(Math::ln($this->r))->add($n->real->multiply($this->phi));
		$real = $k->multiply(Math::cos($y));
		$imaginary = new Imaginary($k->multiply(Math::sin($y))->toNumber());
		$result = new Complex($real, $imaginary);
		return ($rectangular? $result: $result->toPolar());
	}

	public function exp($rectangular=false) {
		// exponential function of e -> eⁿ -> eˣ⁺ⁱʸ
		// where n is ($this->value)
		// eˣ⁺ⁱʸ = eˣ*cos(y) + i*eˣ*sin(y)
		$c = $this->toRectangular();
		$scalar_exp = Math::exp($c->real);
		$real = $scalar_exp->multiply(Math::cos($c->imaginary));
		$imaginary = new Imaginary($scalar_exp->multiply(Math::sin($c->imaginary))->value);
		$result = new Complex($real, $imaginary);
		return ($rectangular? $result: $result->toPolar());
	}

	public function empty(): bool {
		return $this->value['radius']->empty();
	}

	public function isEqual($y): bool {
		// if (Delegator::getType($y)!=self::class) return false;
		$t = Delegator::getType($y);
		if ($t==self::T_COMPLEX) {
			$y = $y->toPolar();
		} else if ($t!=self::class) {
			return false;
		}
		return ($this->r->isEqual($y->r) && $this->phi->isEqual($y->phi));
	}

	public function isNear($y): bool {
		$t = Delegator::getType($y);
		if ($t==self::T_COMPLEX) {
			$y = $y->toPolar();
		} else if ($t!=self::class) {
			return false;
		}
		return ($this->r->isNear($y->r) && $this->phi->isNear($y->phi));
	}

	public function isNaN(): bool {
		return ($this->r->isNaN() || $this->phi->isNaN());
	}
}
?>