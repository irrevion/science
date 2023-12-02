<?php
namespace irrevion\science\Physics\Unit;

enum CGS: string implements SystemInterface {
	case abwatt = 'power.abwatt';
	case abampere = 'electric_current.abampere';
	case barye = 'pressure.barye';
	case ergs_per_second = 'power.ergs_per_second';
	case mole = 'substance_amount.mole';
	case statampere = 'electric_current.statampere';
	case statvolt = 'electric_tension.statvolt';
	case stilb = 'brightness.stilb';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>