<?php
namespace irrevion\science\Physics\Unit;

enum CGS: string implements SystemInterface {
	case abampere = 'electric_current.abampere';
	case mole = 'substance_amount.mole';
	case statampere = 'electric_current.statampere';
	case statvolt = 'electric_tension.statvolt';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>