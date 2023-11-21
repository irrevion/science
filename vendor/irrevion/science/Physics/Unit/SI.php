<?php
namespace irrevion\science\Physics\Unit;

// Le Système International d'Unités
// https://en.wikipedia.org/wiki/International_System_of_Units
enum SI: string implements SystemInterface {
	// 7 base units
	case ampere = 'electric_current.ampere';
	case kelvin = 'temperature.kelvin';
	case kilogram = 'mass.kilogram';
	case kg = 'mass.kg';
	case metre = 'length.metre';
	case mole = 'substance_amount.mole';
	case second = 'time.second';

	// Derived units
	// case celsius = 'temperature.celsius'; // disabled so autocasting still work
	case radian = 'angle.radian';
	case volt = 'electric_tension.volt';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>