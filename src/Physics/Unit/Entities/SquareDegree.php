<?php
namespace irrevion\science\Physics\Unit\Entities;

class SquareDegree implements AngularSquare, NonStandard {
	const name = 'square degree';
	const short_name = 'deg²';
	// const category = 'angular_square'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'deg²';
	//const reference = 3.04617e-4;
	const reference = 3.04613553478e-4;
	const reference_measure = 'sr';
	const alias = '∠Ω';
	const descr = 'A square degree (deg²) is a non-SI unit measure of solid angle. Other denotations include sq. deg. and (°)². Just as degrees are used to measure parts of a circle, square degrees are used to measure parts of a sphere.';
	const base = 'W';
}
?>