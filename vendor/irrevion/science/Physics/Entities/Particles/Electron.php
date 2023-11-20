<?php
namespace irrevion\science\Physics\Entities\Particles;

use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Branches\Relativity;

class Electron /* implements Leptons, Fermions, Particles, Waves */ {
	const MASS = 9.1093837015e-31;
	const CHARGE = -1 * Physics::ELEMENTARY_CHARGE;

	public static function getComptonWavelength() {
		// The Compton wavelength is a quantum mechanical property of a particle, defined as the wavelength of a photon the energy of which is the same as the rest energy of that particle (see mass–energy equivalence). It was introduced by Arthur Compton in 1923 in his explanation of the scattering of photons by electrons (a process known as Compton scattering).
		// λ = h/mc
		$λ = Physics::h / (self::MASS * Physics::c);
		return $λ;
	}

	public static function getDeBroglieWavelength($v) {
		// According to wave-particle duality, the De Broglie wavelength is a wavelength manifested in all the objects in quantum mechanics which determines the probability density of finding the object at a given point of the configuration space. The de Broglie wavelength of a particle is inversely proportional to its momentum.
		// λdB = h/mγv
		$λdB = Physics::h / (self::MASS * Relativity::getLorentzFactor($v) * $v);
		return $λdB;
	}
}
?>