<?php
namespace irrevion\science\Physics\Unit;

enum NonStandard: string implements SystemInterface {
	case arcminute = 'angle.arcminute';
	case celsius = 'temperature.celsius';
	case degree = 'angle.degree';
	case electron_mass = 'mass.electron_mass';
	case electronvolt = 'energy.electronvolt';
	case grad = 'angle.grad';
	case gon = 'angle.gon';
	case mil = 'angle.mil';
	case mrad = 'angle.mrad';
	case nato_mils = 'angle.nato_mils';
	case planck_length = 'length.planck_length';
	case rankine = 'temperature.rankine';
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