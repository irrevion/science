<?php
namespace irrevion\science\Physics\Entities\Particles;

use irrevion\science\Physics\Physics;

class Electron /* implements Leptons, Fermions, Particles, Waves */ {
	const MASS = 9.1093837015e-31;
	const CHARGE = -1 * Physics::ELEMENTARY_CHARGE;

	public static function getComptonWavelength() {
		// The Compton wavelength is a quantum mechanical property of a particle, defined as the wavelength of a photon the energy of which is the same as the rest energy of that particle (see mass–energy equivalence). It was introduced by Arthur Compton in 1923 in his explanation of the scattering of photons by electrons (a process known as Compton scattering).
		// λ = h/mc
		$λ = Physics::h / (self::MASS * Physics::c);
		return $λ;
	}
}
?>