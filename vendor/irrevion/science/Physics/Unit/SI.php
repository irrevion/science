<?php
namespace irrevion\science\Physics\Unit;

// Le Système International d'Unités
// https://en.wikipedia.org/wiki/International_System_of_Units
enum SI: string implements SystemInterface {
	// 7 base units
	case ampere = 'electric_current.ampere';
	case kelvin = 'temperature.kelvin';
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