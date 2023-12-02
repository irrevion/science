<?php
namespace irrevion\science\Physics\Unit\Entities;

class Farad implements Capacitance, SI {
	const name = 'farad';
	const short_name = 'F';
	// const category = 'capacitance'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'F';
	const reference = 1;
	const reference_measure = 'F';
	const alias = '⊣❪―';
	const descr = 'The farad (symbol: F) is the unit of electrical capacitance, the ability of a body to store an electrical charge, in the International System of Units (SI), equivalent to 1 coulomb per volt (C/V). It is named after the English physicist Michael Faraday (1791–1867). In SI base units 1 F = 1 kg−1⋅m−2⋅s4⋅A2.';
	const base = 'L**-2 * M**-1 * T**4 * I**2';
}
?>