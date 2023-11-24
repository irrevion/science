<?php
namespace irrevion\science\Physics\Unit;

// Hartree units
enum Natural: string implements SystemInterface {
	case electron_mass = 'mass.electron_mass';
	case electronvolt = 'energy.electronvolt';
	case planck_length = 'length.planck_length';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>