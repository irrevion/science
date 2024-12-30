<?php
namespace irrevion\science\Physics\Unit\Entities;

class Minute implements Time, NonStandard {
	const name = 'minute';
	const short_name = 'm';
	// const category = 'time'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'm';
	const reference = 60;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'Minute is a unit of time defined as equal to 60 seconds.'; // https://en.wikipedia.org/wiki/Minute
	const base = 'T';
}
?>