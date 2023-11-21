<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Physics\Physics;

class Degree implements Angle, NonStandard {
	const name = 'degree';
	const short_name = '°';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = '°';
	const reference = Physics::PI/180;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'A degree (in full, a degree of arc, arc degree, or arcdegree), usually denoted by ° (the degree symbol), is a measurement of a plane angle in which one full rotation is 360 degrees. It is not an SI unit — the SI unit of angular measure is the radian — but it is mentioned in the SI brochure as an accepted unit. Because a full rotation equals 2π radians, one degree is equivalent to π/180 radians.';
	const base = '';
}
?>