<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Physics\Physics;

class ArcMinute implements Angle, NonStandard {
	const name = 'arcminutes';
	const short_name = 'arcmin';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = '′';
	const reference = Physics::TAU/(360*60);
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'A minute of arc, arcminute (arcmin), arc minute, or minute arc, denoted by the symbol ′, is a unit of angular measurement equal to 1/60 of one degree. Since one degree is 1/360 of a turn, or complete rotation, one arcminute is 1/21600 of a turn.';
	const base = 'A';
}
?>