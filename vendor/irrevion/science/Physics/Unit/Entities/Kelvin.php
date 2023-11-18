<?php
namespace irrevion\science\Physics\Unit\Entities;

class Kelvin implements Temperature, SI {
	const name = 'kelvin';
	const short_name = 'K';
	// const category = 'temperature'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'K';
	const reference = 1;
	const reference_measure = 'K';
	const alias = 'T';
	const descr = 'The kelvin is defined by setting the fixed numerical value of the Boltzmann constant k to 1.380649×10^−23 J⋅K^−1, (J = kg⋅m^2⋅s^−2), given the definition of the kilogram, the metre, and the second.';
	const base = 'Θ';
}
?>