<?php
namespace irrevion\science\Physics\Unit\Entities;

class MonthPrecise implements Time, NonStandard {
	const name = 'month';
	const short_name = 'month';
	// const category = 'time'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'month';
	const reference = 2629800;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'Month as 1/12 of standard year ( wich is 31557600 s ) equal to 2629800 s or 30 days 10 hour 16 minute 40 seconds.';
	const base = 'T';
}
?>