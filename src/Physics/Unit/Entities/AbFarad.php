<?php
namespace irrevion\science\Physics\Unit\Entities;

class AbFarad implements Capacitance, CGS {
	const name = 'abfarad';
	const short_name = 'abF';
	// const category = 'capacitance'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'abF';
	const reference = 1e9;
	const reference_measure = 'F';
	const alias = '⊣❪―';
	const descr = 'A unit of capacitance equal to one billion (10**9) farads, used in the centimeter-gram-second system of units.';
	const base = 'L**-2 * M**-1 * T**4 * I**2';
}
?>