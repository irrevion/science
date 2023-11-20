<?php
namespace irrevion\science\Physics\Unit\Entities;

class Radian implements Angle, SI {
	const name = 'radian';
	const short_name = 'rad';
	// const category = 'electric_current'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'RAD';
	const reference = 1;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'L/2π';
	const base = '';
}
?>