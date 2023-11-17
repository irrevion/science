<?php
namespace irrevion\science\Physics\Unit;

enum SI: string {
	// 7 base units
	case ampere = 'electric_current.ampere';
	case kilogram = 'mass.kilogram';
	case metre = 'length.metre';
	case second = 'time.second';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>