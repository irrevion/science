<?php
namespace irrevion\science\Physics\Unit;

enum IAU: string implements SystemInterface {
	case light_year = 'length.light_year';
	case parsec = 'length.parsec';
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