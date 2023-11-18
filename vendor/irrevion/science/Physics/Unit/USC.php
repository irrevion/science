<?php
namespace irrevion\science\Physics\Unit;

enum USC: string implements SystemInterface {
	case fahrenheit = 'temperature.fahrenheit';
	case pound = 'mass.pound';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>