<?php
namespace irrevion\science\Physics\Unit\Entities;

class Metre implements Length, SI {
	const name = 'metre';
	const short_name = 'm';
	// const category = 'length'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'm';
	const reference = 1;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = 'The distance travelled by light in vacuum in 1/299792458 seconds.';
	const base = 'L';
}
?>