<?php
namespace irrevion\science\Physics\Unit;

enum NonStandard: string implements SystemInterface {
	case A = 'length.angstrom';
	case AMU = 'mass.AMU';
	case apostilb = 'brightness.apostilb';
	case arcminute = 'angle.arcminute';
	case arcsecond = 'angle.arcsecond';
	case attometre = 'length.attometre';
	case bohr_radius = 'length.bohr_radius';
	case celsius = 'temperature.celsius';
	case dalton = 'mass.dalton';
	case day = 'time.day';
	case degree = 'angle.degree';
	case electron_mass = 'mass.electron_mass';
	case electronvolt = 'energy.electronvolt';
	case gigaparsec = 'length.gigaparsec';
	case grad = 'angle.grad';
	case gon = 'angle.gon';
	case hour = 'time.hour';
	case km = 'length.km';
	case kilometre = 'length.kilometre';
	case mas = 'angle.mas';
	case microarcsecond = 'angle.microarcsecond';
	case mil = 'angle.mil';
	case milliarcsecond = 'angle.milliarcsecond';
	case minute = 'time.minute';
	case mrad = 'angle.mrad';
	case nanoradian = 'angle.nanoradian';
	case nato_mils = 'angle.nato_mils';
	case nrad = 'angle.nrad';
	case planck_length = 'length.planck_length';
	case rankine = 'temperature.rankine';
	case Ry = 'energy.Ry';
	case rydberg_energy = 'energy.rydberg';
	case rydberg_wavelength = 'length.rydberg_wavelength';
	case sidereal_day = 'time.sidereal_day';
	case solar_day = 'time.solar_day';
	case spat = 'angular_square.spat';
	case square_arcminute = 'angular_square.square_arcminute';
	case square_arcsecond = 'angular_square.square_arcsecond';
	case square_degree = 'angular_square.square_degree';
	case stellar_day = 'time.stellar_day';
	case turn = 'angle.turn';
	case ussr_mrad = 'angle.ussr_mrad';
	case year = 'time.year';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>