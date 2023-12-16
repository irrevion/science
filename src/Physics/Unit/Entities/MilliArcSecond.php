<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Physics\Physics;

class MilliArcSecond implements Angle, NonStandard {
	const name = 'milliarcsecond';
	const short_name = 'mas';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'mas';
	const reference = Physics::TAU/1296e6;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'Milliarcsecond is approximately 4.8481368 nrad.';
	const base = 'A';
}
?>