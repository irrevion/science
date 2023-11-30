<?php
namespace irrevion\science\Physics\Unit\Entities;

class Newton implements Force, SI {
	const name = 'newton';
	const short_name = 'N';
	// const category = 'force'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'N';
	const reference = 1;
	const reference_measure = 'N';
	const alias = 'F';
	const descr = 'The newton (symbol: N) is the unit of force in the International System of Units (SI). It is defined as 1 kg*m/s**2, the force which gives a mass of 1 kilogram an acceleration of 1 metre per second per second.';
	const base = 'LMT**-2';
}
?>