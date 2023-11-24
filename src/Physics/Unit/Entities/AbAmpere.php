<?php
namespace irrevion\science\Physics\Unit\Entities;

class AbAmpere implements ElectricCurrent, CGS { // CGS-EMU
	const name = 'abampere';
	const short_name = 'abA';
	// const category = 'electric_current'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'abA';
	const reference = 10;
	const reference_measure = 'A';
	const alias = 'I';
	const descr = 'The abampere (abA), also called the biot (Bi) after Jean-Baptiste Biot, is the derived electromagnetic unit of electric current in the emu-cgs system of units (electromagnetic cgs). One abampere corresponds to ten amperes in the SI system of units. An abampere of current in a circular path of one centimeter radius produces a magnetic field of 2π oersteds at the center of the circle.';
	const base = '';
}
?>