<?php
namespace irrevion\science\Physics\Unit\Entities;

class Month implements Time, NonStandard {
	const name = 'month';
	const short_name = 'month';
	// const category = 'time'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'month';
	const reference = 2592000;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'The standard financial 30 day month.';
	const base = 'T';
}
?>