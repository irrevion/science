<?php
namespace irrevion\science\Physics\Unit;

enum NonStandard: string implements SystemInterface {
	case celsius = 'temperature.celsius';
	case electron_mass = 'mass.electron_mass';
	case electronvolt = 'energy.electronvolt';
	case planck_length = 'length.planck_length';
	case rankine = 'temperature.rankine';
	case year = 'time.year';
	case degree = 'angle.degree';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>