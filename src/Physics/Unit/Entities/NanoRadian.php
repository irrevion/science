<?php
namespace irrevion\science\Physics\Unit\Entities;

class NanoRadian implements Angle, SI {
	const name = 'nanoradian';
	const short_name = 'nrad';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'nRAD';
	const reference = 1e-9;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = '1e-3 radian';
	const base = 'A';
}
?>