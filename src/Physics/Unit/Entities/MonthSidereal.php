<?php
namespace irrevion\science\Physics\Unit\Entities;

class MonthSidereal implements Time, NonStandard {
	const name = 'month';
	const short_name = 'month';
	// const category = 'time'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'month';
	const reference = 2360591.5104;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'Moon`s orbital period in a non-rotating frame of reference (which on average is equal to its rotation period in the same frame). It is about 27.32166 days (27 days, 7 hours, 43 minutes, 11.6 seconds)';
	const base = 'T';
}
?>