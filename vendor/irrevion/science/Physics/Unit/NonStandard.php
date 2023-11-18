<?php
namespace irrevion\science\Physics\Unit;

enum NonStandard: string implements SystemInterface {
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