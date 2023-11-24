<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Physics\Physics;

class Celsius implements Temperature, NonStandard {
	const name = 'celsius';
	const short_name = 'C';
	// const category = 'temperature'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = '°C';
	const reference = 0; // use methods instead
	const reference_measure = 'K';
	const alias = 'T';
	const descr = 'The degree Celsius is the unit of temperature on the Celsius scale (originally known as the centigrade scale outside Sweden), one of two temperature scales used in the International System of Units (SI), the other being the Kelvin scale.';
	const base = '';

	public static function toRef($x) {
		$ref = $x+273.15;
		if ($ref<0) {
			// if (Physics::compare($ref, '=', 0)) {
			if (abs($ref)<PHP_FLOAT_EPSILON) {
				$ref = 0;
			} else {
				throw new \Error('Temperature in Kelvins cannot be negative ('.$ref.')');
			}
		}
		return $ref;
	}

	public static function fromRef($x) {
		$val = $x-273.15;
		if (Physics::compare($val, '<', -273.15)) {
			throw new \Error('Temperature in Celsius degrees cannot be less than -273.15 ('.$val.')');
		}
		return $val;
	}
}
?>