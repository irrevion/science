<?php
namespace irrevion\science\Physics\Unit\Entities;

class Second implements Time, SI {
	const name = 'second';
	const short_name = 's';
	// const category = 'time'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 's';
	const reference = 1;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'The duration of 9192631770 periods of the radiation corresponding to the transition between the two hyperfine levels of the ground state of the caesium-133 atom.';
	const base = 'T';
}
?>