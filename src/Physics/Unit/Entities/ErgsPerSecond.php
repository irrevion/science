<?php
namespace irrevion\science\Physics\Unit\Entities;

class ErgsPerSecond implements Power, CGS {
	const name = 'ergs per second';
	const short_name = 'erg/s';
	// const category = 'power'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'erg/s';
	const reference = 1e-7;
	const reference_measure = 'W';
	const alias = 'P';
	const descr = 'A erg per second (symbol: erg/s) is the unit of power in CGS, equal 10-7 watt. ';
	const base = 'L**2*M*T***-3';
}
?>