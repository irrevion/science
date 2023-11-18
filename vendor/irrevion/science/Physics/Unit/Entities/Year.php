<?php
namespace irrevion\science\Physics\Unit\Entities;

class Year implements Time, NonStandard {
	const name = 'year';
	const short_name = 'y';
	// const category = 'time'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'y';
	const reference = 31557600; // 365.25 days * 24 hours * 3600 seconds
	const reference_measure = 's';
	const alias = 't';
	const descr = 'For the Gregorian calendar, the average length of the calendar year (the mean year) across the complete leap cycle of 400 years is 365.2425 days (97 out of 400 years are leap years). The Julian year, as used in astronomy and other sciences, is a time unit defined as exactly 365.25 days of 86,400 SI seconds each ("ephemeris days"). This is the normal meaning of the unit "year" used in various scientific contexts.';
	const base = 'T';
}
?>