<?php
namespace irrevion\science\Physics\Unit;

enum IAU: string implements SystemInterface {
	case astronomical_unit = 'length.astronomical_unit';
	case au = 'length.au';
	case light_year = 'length.light_year';
	case ly = 'length.ly';
	case parsec = 'length.parsec';
	case solar_mass = 'mass.solar_mass';
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