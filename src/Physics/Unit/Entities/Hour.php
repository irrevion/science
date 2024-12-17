<?php
namespace irrevion\science\Physics\Unit\Entities;

class Hour implements Time, NonStandard {
	const name = 'hour';
	const short_name = 'h';
	// const category = 'time'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'h';
	const reference = 3600;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'An hour (symbol: h also abbreviated hr) is a unit of time historically reckoned as 1⁄24 of a day and defined contemporarily as exactly 3,600 seconds (SI). There are 60 minutes in an hour, and 24 hours in a day.'; // https://en.wikipedia.org/wiki/Hour
	const base = 'T';
}
?>