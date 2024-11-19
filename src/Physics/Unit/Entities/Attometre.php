<?php
namespace irrevion\science\Physics\Unit\Entities;

class Attometre implements Length, NonStandard {
	const name = 'attometre';
	const short_name = 'attometre';
	// const category = 'length'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'am';
	const reference = 1e-18;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = '10^-18 metres.';
	const base = 'L';
}
?>