<?php
namespace irrevion\science\Physics\Unit;

enum IAU: string {
	case light_year = 'length.light_year';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>