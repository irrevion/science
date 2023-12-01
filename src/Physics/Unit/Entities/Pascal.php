<?php
namespace irrevion\science\Physics\Unit\Entities;

class Pascal implements Pressure, SI {
	const name = 'pascal';
	const short_name = 'Pa';
	// const category = 'pressure'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'Pa';
	const reference = 1;
	const reference_measure = 'Pa';
	const alias = 'P';
	const descr = 'The pascal (symbol: Pa) is the unit of pressure in the International System of Units (SI). It is also used to quantify internal pressure, stress, Young\'s modulus, and ultimate tensile strength.';
	const base = 'M*L**-1*T**-2';
}
?>