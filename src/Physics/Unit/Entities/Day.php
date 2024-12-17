<?php
namespace irrevion\science\Physics\Unit\Entities;

class Day implements Time, NonStandard {
	const name = 'day';
	const short_name = 'd';
	// const category = 'time'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'd';
	const reference = 86400;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'The modern 24-hour clock is the convention of timekeeping in which the day runs from midnight to midnight and is divided into 24 hours. This is indicated by the hours (and minutes) passed since midnight, from 00(:00) to 23(:59), with 24(:00) as an option to indicate the end of the day. This system, as opposed to the 12-hour clock, is the most commonly used time notation in the world today, and is used by the international standard ISO 8601.'; // https://en.wikipedia.org/wiki/24-hour_clock
	const base = 'T';
}
?>