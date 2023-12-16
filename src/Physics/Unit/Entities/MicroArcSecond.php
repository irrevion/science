<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Physics\Physics;

class MicroArcSecond implements Angle, NonStandard {
	const name = 'microarcsecond';
	const short_name = 'μas';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'μas';
	const reference = 4.8481368110953E-12;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'Microarcsecond is approximately 4.8481368110953E-12 rad.';
	const base = 'A';
}
?>