<?php
namespace irrevion\science\Physics\Unit;

enum Planck: string implements SystemInterface {
	case energy = 'energy.planck_energy';
	case force = 'force.planck_force';
	case length = 'length.planck_length';
	case time = 'time.planck_time';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>