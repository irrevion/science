<?php
namespace irrevion\science\Physics\Unit\Entities;

class Kilometre implements Length, NonStandard {
	const name = 'kilometre';
	const short_name = 'km';
	// const category = 'length'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'km';
	const reference = 1000;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = '1000 metres.';
	const base = 'L';
}
?>