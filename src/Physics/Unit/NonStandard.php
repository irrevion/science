<?php
namespace irrevion\science\Physics\Unit;

enum NonStandard: string implements SystemInterface {
	case celsius = 'temperature.celsius';
	case degree = 'angle.degree';
	case electron_mass = 'mass.electron_mass';
	case electronvolt = 'energy.electronvolt';
	case grad = 'angle.grad';
	case gon = 'angle.gon';
	case planck_length = 'length.planck_length';
	case rankine = 'temperature.rankine';
	case turn = 'angle.turn';
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