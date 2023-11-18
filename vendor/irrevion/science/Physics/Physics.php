<?php
namespace irrevion\science\Physics;

use irrevion\science\Math\Math;
use irrevion\science\Physics\Unit\Categories;

class Physics extends Math {
	// all constant values given assuming SI sistem of units
	const ALPHA = 0.0072973525693;
	// https://en.wikipedia.org/wiki/Fine-structure_constant
	// fine structure constant, also known as the Sommerfeld constant, commonly denoted by α, is a fundamental physical constant which quantifies the strength of the electromagnetic interaction between elementary charged particles.

	public static function unit($unit) { // cast unit as array
		if (is_array($unit)) {
			if (!empty($unit['category']) && !empty($unit['name'])) {
				return $unit;
			}
		} else if (is_string($unit)) {
			$unit_reflection = Categories::get($unit);
		} else if (is_object($unit)) {
			if ($unit instanceof Unit\SystemInterface) {
				$unit_reflection = $unit->i();
			} else if ($unit instanceof \ReflectionClass) {
				$unit_reflection = $unit;
			}
		}

		if (empty($unit_reflection)) {
			throw new \Error('Unknown type of unit');
		}

		return $unit_reflection->getConstants();
	}

	public static function convert(Entities\Quantity $v, mixed $to) {
		$from = self::unit($v->unit);
		$to = self::unit($to);
		if ($from['category']!=$to['category']) {
			throw new \Error($from['category'].' does not match '.$to['category']);
		}
		$converted = (($v->value * $from['reference']) / $to['reference']);

		return new Entities\Quantity($converted, $to);
	}
}

?>