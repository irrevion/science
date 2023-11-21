<?php
namespace irrevion\science\Physics\Unit\Entities;

class Radian implements Angle, SI {
	const name = 'radian';
	const short_name = 'rad';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'RAD';
	const reference = 1;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'The radian, denoted by the symbol rad, is the unit of angle in the International System of Units (SI) and is the standard unit of angular measure used in many areas of mathematics. It is defined such that one radian is the angle subtended at the centre of a circle by an arc that is equal in length to the radius. The unit was formerly an SI supplementary unit and is currently a dimensionless SI derived unit, defined in the SI as 1 rad = 1 and expressed in terms of the SI base unit metre (m) as rad = m/m. Angles without explicitly specified units are generally assumed to be measured in radians, especially in mathematical writing.';
	const base = '';
}
?>