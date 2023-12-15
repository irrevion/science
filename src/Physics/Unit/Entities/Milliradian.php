<?php
namespace irrevion\science\Physics\Unit\Entities;

class Milliradian implements Angle, NonStandard {
	const name = 'Milliradian';
	const short_name = 'mrad';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'mrad';
	const reference = 1/1000;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'A milliradian (SI-symbol mrad, sometimes also abbreviated mil) is an SI derived unit for angular measurement which is defined as a thousandth of a radian (0.001 radian). Milliradians are used in adjustment of firearm sights by adjusting the angle of the sight compared to the barrel (up, down, left, or right). Milliradians are also used for comparing shot groupings, or to compare the difficulty of hitting different sized shooting targets at different distances.';
	const base = 'A';
}
?>