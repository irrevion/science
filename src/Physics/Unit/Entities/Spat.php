<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Math\Math;

class Spat implements AngularSquare, NonStandard {
	const name = 'spat';
	const short_name = 'sp';
	// const category = 'angular_square'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'sp';
	const reference = Math::PI*4;
	const reference_measure = 'sr';
	const alias = '∠Ω';
	const descr = 'The spat (symbol sp), from the Latin spatium ("space"), is a unit of solid angle. 1 spat is equal to 4π steradians or approximately 41253 square degrees of solid angle. Thus it is the solid angle subtended by a complete sphere at its center.';
	const base = 'W';
}
?>