<?php
namespace irrevion\science\Physics\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Unit\Categories;
use irrevion\science\Physics\Unit\{SI, Planck, IAU, CGS, Natural, NonStandard, Imperial, USC};

class Quantity {
	public $value;
	public $unit;

	public function __construct($value, $unit) {
		$this->value = $value;
		$unit = Physics::unit($unit);
		$this->unit = $unit;
	}

	public function __toString() {
		return "{$this->value} {$this->unit['measure']}";
	}

	public function toNumber() {
		return $this->value;
	}

	public function convert($to) {
		return Physics::convert($this, $to);
	}

	public function i($const='') {
		// $reflection = new \ReflectionClass($this->unit);
		// $reflection = $this->unit;
		// if (empty($const)) {
		// 	return $reflection;
		// }
		// return $reflection->getConstant($const);

		return (empty($const)? $this->unit: $this->unit[$const]);
	}

	public static function stringifyTimeInterval($seconds): string {
		$seconds = Math::abs($seconds);
		$t = new Quantity($seconds, SI::second);
		$string = '';
		$y = $t->convert('time.year');
		if ($y->value>=1) {
			$u = floor($y->value);
			$string.=sprintf("%u year%s ", $u, (($u>1)? 's': ''));
			$t->value-=(new Quantity($u, 'time.year'))->convert(SI::second)->value;
		}
		$m = $t->convert('time.month_precise');
		if ($m->value>=1) {
			$u = floor($m->value);
			$string.=sprintf("%u month%s ", $u, (($u>1)? 's': ''));
			$t->value-=(new Quantity($u, 'time.month_precise'))->convert(SI::second)->value;
		}
		$d = $t->convert('time.day');
		if ($d->value>=1) {
			$u = floor($d->value);
			$string.=sprintf("%u day%s ", $u, (($u>1)? 's': ''));
			$t->value-=(new Quantity($u, 'time.day'))->convert(SI::second)->value;
		}
		$h = $t->convert('time.hour');
		if ($h->value>=1) {
			$u = floor($h->value);
			$string.=sprintf("%u hour%s ", $u, (($u>1)? 's': ''));
			$t->value-=(new Quantity($u, 'time.hour'))->convert(SI::second)->value;
		}
		$i = $t->convert('time.minute');
		if ($i->value>=1) {
			$u = floor($i->value);
			$string.=sprintf("%u minute%s ", $u, (($u>1)? 's': ''));
			$t->value-=(new Quantity($u, 'time.minute'))->convert(SI::second)->value;
		}
		$s = $t->convert('time.second');
		$u = floor($s->value);
		if ($s->value) $string.="{$s->value} second".(($u>1)? 's': '');
		$string = trim($string);
		return ($string? $string: '0.00 seconds');
	}
}
?>