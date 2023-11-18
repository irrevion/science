<?php
namespace irrevion\science\Physics\Unit\Entities;

class StatAmpere implements ElectricCurrent, CGS { // CGS-ESU
	const name = 'statampere';
	const short_name = 'statA';
	// const category = 'electric_current'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'statA';
	const reference = 3.33564e-10;
	const reference_measure = 'A';
	const alias = 'I';
	const descr = 'The statampere (statA) is the derived electromagnetic unit of electric current in the CGS-ESU (electrostatic cgs) and Gaussian systems of units. One statampere corresponds to 10/ccgs ampere ≈ 3.33564×10^−10 ampere in the SI system of units.';
	const base = '';
}
?>