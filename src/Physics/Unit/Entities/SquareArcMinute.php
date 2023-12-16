<?php
namespace irrevion\science\Physics\Unit\Entities;

class SquareArcMinute implements AngularSquare, NonStandard {
	const name = 'square arcminute';
	const short_name = 'arcmin²';
	// const category = 'angular_square'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'arcmin²';
	//const reference = 8.461594994105509e-8;
	const reference = 8.46159496424E-8;
	const reference_measure = 'sr';
	const alias = '∠Ω';
	const descr = 'Square Arcminute (sq \') is a unit in the category of Solid angle. It is also known as sq arcmin. Square Arcminute (sq \') has a dimension of W. It can be converted to the corresponding standard SI unit sr by multiplying its value by a factor of 8.46159496424E-8.';
	const base = 'W';
}
?>