<?php
namespace irrevion\science\Physics\Unit;

enum Planck: string implements SystemInterface {
	case length = 'length.planck_length';

	public function i($const='') {
		$reflection = Categories::get($this->value);
		if (empty($const)) {
			return $reflection;
		}
		return $reflection->getConstant($const);
	}
}
?>