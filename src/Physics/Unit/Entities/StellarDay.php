<?php
namespace irrevion\science\Physics\Unit\Entities;

class StellarDay implements Time, IAU {
	const name = 'stellar day';
	const short_name = 'stellar days';
	// const category = 'time'; // defined by interface
	// const unit_system = 'IAU'; // defined by interface
	const measure = 'stellar days';
	const reference = 86164.098903691;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'Earth`s rotation period relative to the International Celestial Reference Frame, called its stellar day by the International Earth Rotation and Reference Systems Service (IERS), is 86 164.098 903 691 seconds of mean solar time (UT1) (23h 56m 4.098903691s, 0.99726966323716 mean solar days).';
	// https://en.wikipedia.org/wiki/Earth%27s_rotation
	const base = 'T';
}
?>