<?php
namespace irrevion\science\Physics;

use irrevion\science\Math\Math;
use irrevion\science\Physics\Unit\Categories;

class Physics extends Math {
	// all constant values given assuming SI sistem of units

	const ALPHA = 0.0072973525693;
	const α = self::ALPHA;
	// https://en.wikipedia.org/wiki/Fine-structure_constant
	// Fine structure constant, also known as the Sommerfeld constant, commonly denoted by α, is a fundamental physical constant which quantifies the strength of the electromagnetic interaction between elementary charged particles.

	const BOLTZMANN = 1.380649e-23; // J*K^-1
	const k = self::BOLTZMANN;
	// https://en.wikipedia.org/wiki/Boltzmann_constant
	// The Boltzmann constant (kB or k) is the proportionality factor that relates the average relative thermal energy of particles in a gas with the thermodynamic temperature of the gas. It occurs in the definitions of the kelvin and the gas constant, and in Planck's law of black-body radiation and Boltzmann's entropy formula, and is used in calculating thermal noise in resistors. The Boltzmann constant has dimensions of energy divided by temperature, the same as entropy.

	const C = 299792458; // m/s
	const c = self::C;
	// https://en.wikipedia.org/wiki/Speed_of_light
	// The speed of light in vacuum, commonly denoted c, is a universal physical constant that is exactly equal to 299,792,458 metres per second (approximately 300,000 kilometres per second; 186,000 miles per second; 671 million miles per hour).

	const G = 6.6743e-11; // N*m^2/kg^2
	// https://en.wikipedia.org/wiki/Gravitational_constant
	// The gravitational constant (also known as the universal gravitational constant, the Newtonian constant of gravitation, or the Cavendish gravitational constant), denoted by the capital letter G, is an empirical physical constant involved in the calculation of gravitational effects in Sir Isaac Newton's law of universal gravitation and in Albert Einstein's theory of general relativity.

	const h = 6.62607015e-34; // J*Hz^−1
	const PLANCK = self::h; // J*Hz^−1
	// https://en.wikipedia.org/wiki/Planck_constant
	// The Planck constant, or Planck's constant, denoted by h, is a fundamental physical constant of foundational importance in quantum mechanics: a photon's energy is equal to its frequency multiplied by the Planck constant, and the wavelength of a matter wave equals the Planck constant divided by the associated particle momentum.

	const PLANCK_REDUCED = 1.054571817e-34;
	const ℏ = 1.054571817e-34; // Js
	// Plank constant over 2π


	public static function unit($unit) { // cast unit as array
		if (is_array($unit)) {
			if (!empty($unit['category']) && !empty($unit['name'])) {
				return $unit;
			}
		} else if (is_string($unit)) {
			$unit_reflection = Categories::get($unit);
		} else if (is_object($unit)) {
			if ($unit instanceof Unit\SystemInterface) {
				$unit_reflection = $unit->i();
			} else if ($unit instanceof \ReflectionClass) {
				$unit_reflection = $unit;
			}
		}

		if (empty($unit_reflection)) {
			throw new \Error('Unknown type of unit');
		}

		$i = $unit_reflection->getConstants();
		$i['path'] = $i['category'].'.'.$i['name'];
		$i['reflection'] = $unit_reflection;

		return $i;
	}

	public static function convert(Entities\Quantity $v, mixed $to) {
		$from = self::unit($v->unit);
		$to = self::unit($to);
		if ($from['category']!=$to['category']) {
			throw new \Error($from['category'].' does not match '.$to['category']);
		}

		// $converted = (($v->value * $from['reference']) / $to['reference']);
		$converted = 0;
		$restored = 0;
		if ($from['reflection']->hasMethod('toRef')) {
			$restored = $from['reflection']->getMethod('toRef')->invoke(null, $v->value);
		} else {
			$restored = $v->value * $from['reference'];
		}
		if ($to['reflection']->hasMethod('fromRef')) {
			$converted = $to['reflection']->getMethod('fromRef')->invoke(null, $restored);
		} else {
			$converted = $restored / $to['reference'];
		}

		return new Entities\Quantity($converted, $to);
	}

	public static function q($v, Unit\SystemInterface $t) {
		if ($t instanceof Unit\SI) return $v;
		$i = $t->i();
		if ($i->hasMethod('toRef')) {
			return $i->getMethod('toRef')->invoke(null, $v);
		} else {
			return $v * $i->getConstant('reference');
		}
	}
}

?>