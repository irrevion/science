<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Physics\Physics;

class ArcSecond implements Angle, NonStandard {
	const name = 'arcsecond';
	const short_name = '″';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = '″';
	const reference = Physics::TAU/(21600*60);
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'A second of arc, arcsecond (arcsec), or arc second, denoted by the symbol ″, is 1/60 of an arcminute, 1/3600 of a degree, 1/1296000 of a turn, and π/648000 (about 1/206264.8) of a radian.';
	const base = 'A';
}
?>