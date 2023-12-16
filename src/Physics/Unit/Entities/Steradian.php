<?php
namespace irrevion\science\Physics\Unit\Entities;

class Steradian implements AngularSquare, SI {
	const name = 'steradian';
	const short_name = 'sr';
	// const category = 'angular_square'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'sr';
	const reference = 1;
	const reference_measure = 'sr';
	const alias = '∠Ω';
	const descr = 'The steradian (symbol: sr) or square radian is the unit of solid angle in the International System of Units (SI). It is used in three dimensional geometry, and is analogous to the radian, which quantifies planar angles. Whereas an angle in radians, projected onto a circle, gives a length of a circular arc on the circumference, a solid angle in steradians, projected onto a sphere, gives the area of a spherical cap on the surface.';
	const base = 'W';
}
?>