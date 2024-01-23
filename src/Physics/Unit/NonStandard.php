<?php
namespace irrevion\science\Physics\Unit;

enum NonStandard: string implements SystemInterface {
	case AMU = 'mass.AMU';
	case arcminute = 'angle.arcminute';
	case arcsecond = 'angle.arcsecond';
	case celsius = 'temperature.celsius';
	case dalton = 'mass.dalton';
	case degree = 'angle.degree';
	case electron_mass = 'mass.electron_mass';
	case electronvolt = 'energy.electronvolt';
	case grad = 'angle.grad';
	case gon = 'angle.gon';
	case mas = 'angle.mas';
	case microarcsecond = 'angle.microarcsecond';
	case mil = 'angle.mil';
	case milliarcsecond = 'angle.milliarcsecond';
	case mrad = 'angle.mrad';
	case nanoradian = 'angle.nanoradian';
	case nato_mils = 'angle.nato_mils';
	case nrad = 'angle.nrad';
	case planck_length = 'length.planck_length';
	case rankine = 'temperature.rankine';
	case square_arcminute = 'angular_square.square_arcminute';
	case square_arcsecond = 'angular_square.square_arcsecond';
	case square_degree = 'angular_square.square_degree';
	case spat = 'angular_square.spat';
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