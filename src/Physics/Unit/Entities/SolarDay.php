<?php
namespace irrevion\science\Physics\Unit\Entities;

class SolarDay implements Time, NonStandard {
	const name = 'mean solar day';
	const short_name = 'mean solar days';
	// const category = 'time'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'mean solar days';
	const reference = 86400.002; // at 2008 year
	const reference_measure = 's';
	const alias = 't';
	const descr = 'A synodic day (or synodic rotation period or solar day) is the period for a celestial object to rotate once in relation to the star it is orbiting, and is the basis of solar time. The duration of daylight varies during the year but the length of a mean solar day is nearly constant, unlike that of an apparent solar day. An apparent solar day can be 20 seconds shorter or 30 seconds longer than a mean solar day. As of 2008, a mean solar day is about 86,400.002 SI seconds, i.e., about 24.0000006 hours.';
	// https://en.wikipedia.org/wiki/Solar_time#Mean_solar_time
	// https://en.wikipedia.org/wiki/Synodic_day
	const base = 'T';
}
?>