<?php
namespace irrevion\science\Physics\Unit\Entities;

class SquareArcSecond implements AngularSquare, NonStandard {
	const name = 'square arcsecond';
	const short_name = 'arcsec²';
	// const category = 'angular_square'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'arcsec²';
	const reference = 2.35044305391E-11;
	const reference_measure = 'sr';
	const alias = '∠Ω';
	const descr = 'Square Arcsec (sq ") is a unit in the category of Solid angle. It is also known as sq arcsec. Square Arcsec (sq ") has a dimension of W. It can be converted to the corresponding standard SI unit sr by multiplying its value by a factor of 2.35044305391E-11.';
	const base = 'W';
}
?>