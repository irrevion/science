<?php
namespace irrevion\science\Physics\Unit\Entities;

class SiderealDay implements Time, NonStandard {
	const name = 'sidereal day';
	const short_name = 'sidereal days';
	// const category = 'time'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'sidereal days';
	const reference = 86164.0905;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'The time between two consecutive transits of the First Point of Aries. It represents the time taken by the earth to rotate on its axis relative to the stars, and is almost four minutes shorter than the solar day because of the earth`s orbital motion.';
	const base = 'T';
}
?>