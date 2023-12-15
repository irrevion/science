<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Math\Math;

class Turn implements Angle, NonStandard {
	const name = 'turn';
	const short_name = 'turn';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'rev';
	const reference = Math::TAU;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'One turn (symbol tr or pla) is a unit of plane angle measurement equal to 2π radians, 360 degrees or 400 gradians. Thus it is the angular measure subtended by a complete circle at its center.';
	const base = 'A';
}
?>