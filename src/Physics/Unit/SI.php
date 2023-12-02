<?php
namespace irrevion\science\Physics\Unit;

// Le Système International d'Unités
// https://en.wikipedia.org/wiki/International_System_of_Units
enum SI: string implements SystemInterface {
	// 7 base units
	case ampere = 'electric_current.ampere';
	case kelvin = 'temperature.kelvin';
	case K = 'temperature.K';
	case kilogram = 'mass.kilogram';
	case kg = 'mass.kg';
	case metre = 'length.metre';
	case mole = 'substance_amount.mole';
	case second = 'time.second';

	// Derived units
	case caesium133 = 'frequency.caesium133';
	case candela_per_square_metre = 'brightness.candela_per_square_metre';
	// case celsius = 'temperature.celsius'; // disabled so autocasting still work
	case coulomb = 'electric_charge.coulomb';
	case C = 'electric_charge.C';
	case farad = 'capacitance.farad';
	case newton = 'force.newton';
	case N = 'force.N';
	case hertz = 'frequency.hertz';
	case Hz = 'frequency.Hz';
	case joule = 'energy.joule';
	case J = 'energy.J';
	case nit = 'brightness.nit';
	case radian = 'angle.radian';
	case pascal = 'pressure.pascal';
	case Pa = 'pressure.Pa';
	case volt = 'electric_tension.volt';
	case watt = 'power.watt';
	case W = 'power.W';
	case watt_second = 'energy.watt_second';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>