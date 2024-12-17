<?php
namespace irrevion\science\Physics\Unit\Entities;

class Centimetre implements Length, CGS {
	const name = 'centimetre';
	const short_name = 'sm';
	// const category = 'length'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'sm';
	const reference = 1e-2;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = '1/100 of a metre.';
	const base = 'L';
}
?>