<?php
namespace irrevion\science\Physics;

use irrevion\science\Math\Math;
use irrevion\science\Physics\Unit\Categories;

class Physics extends Math {
	// all constant values given assuming SI sistem of units
	const ALPHA = 0.0072973525693;
	// https://en.wikipedia.org/wiki/Fine-structure_constant
	// fine structure constant, also known as the Sommerfeld constant, commonly denoted by α, is a fundamental physical constant which quantifies the strength of the electromagnetic interaction between elementary charged particles.

	public static function unit() {
		// print Unit\SI::mass->unit()." is a unit of ".Unit\SI::mass->name." (".Unit\SI::mass->alias()." = ".Unit\SI::mass->reference()." ".Unit\SI::mass->measure().")\n";
		// print "* ".Unit\SI::mass->descr()." \n";
		// print "* ".Unit\NonStandard::energy['electronvolt']['measure']." \n";
		// print "* ".Unit\NonStandard::volume['barrel']." \n";
		print Unit\Si::kilogram->value." \n";
		// var_export(Unit\Si::kilogram->i());
		print Unit\SI::kilogram->i('name')." is a unit of ".Unit\SI::kilogram->i('category')." (".Unit\SI::kilogram->i('alias')." = ".Unit\SI::kilogram->i('reference')." ".Unit\SI::kilogram->i('measure').")\n";
	}

	public static function convert(Entities\Quantity $v, mixed $to) {
		// $from = new \ReflectionClass($v->unit);
		$from = $v->unit;
		$from_cat = $from->getConstant('category');
		if (is_string($to)) {
			$to = Categories::get($to);
		}
		$to_cat = $to->getConstant('category');
		if ($from_cat!=$to_cat) {
			throw new \Error($from_cat.' does not match '.$to_cat);
		}
		$converted = ($v->value * $from->getConstant('reference') * $to->getConstant('reference'));

		return new Entities\Quantity($converted, $to);
	}
}

?>