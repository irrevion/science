<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Physics\Physics;

class Fahrenheit implements Temperature, Imperial {
	const name = 'fahrenheit';
	const short_name = 'F';
	// const category = 'temperature'; // defined by interface
	// const unit_system = 'Imperial'; // defined by interface
	const measure = '°F';
	const reference = 0; // use methods instead
	const reference_measure = 'K';
	const alias = 'T';
	const descr = 'The Fahrenheit scale is a temperature scale based on one proposed in 1724 by the European physicist Daniel Gabriel Fahrenheit (1686–1736). It uses the degree Fahrenheit (symbol: °F) as the unit. Several accounts of how he originally defined his scale exist, but the original paper suggests the lower defining point, 0 °F, was established as the freezing temperature of a solution of brine made from a mixture of water, ice, and ammonium chloride (a salt). The other limit established was his best estimate of the average human body temperature, originally set at 90 °F, then 96 °F (about 2.6 °F less than the modern value due to a later redefinition of the scale).';
	const base = '';

	public static function toRef($x) {
		$ref = ($x + 459.67) * 5 / 9;
		if ($ref<0) {
			if (abs($ref)<PHP_FLOAT_EPSILON) {
				$ref = 0;
			} else {
				throw new \Error('Temperature in Kelvins cannot be negative ('.$ref.')');
			}
		}
		return $ref;
	}

	public static function fromRef($x) {
		$val = $x * 9 / 5 - 459.67;
		if (Physics::compare($val, '<', -459.67)) {
			throw new \Error('Temperature in Fahrenheit degrees cannot be less than -459.67 ('.$val.')');
		}
		return $val;
	}
}
?>