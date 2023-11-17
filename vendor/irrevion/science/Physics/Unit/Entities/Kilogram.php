<?php
namespace irrevion\science\Physics\Unit\Entities;

class Kilogram implements Mass, SI {
	const name = 'kilogram';
	const short_name = 'kg';
	// const category = 'mass'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'kg';
	const reference = 1;
	const reference_measure = 'kg';
	const alias = 'm';
	const descr = 'The kilogram is defined by setting the Planck constant h exactly to 6.62607015×10−34 J⋅s (J = kg⋅m²⋅s−2), given the definitions of the metre and the second.';
	const base = 'M';
}
?>