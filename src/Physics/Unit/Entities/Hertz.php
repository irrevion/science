<?php
namespace irrevion\science\Physics\Unit\Entities;

class Hertz implements Frequency, SI {
	const name = 'hertz';
	const short_name = 'Hz';
	// const category = 'frequency'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'Hz';
	const reference = 1;
	const reference_measure = 'Hz';
	const alias = 'ν';
	const descr = 'The hertz (symbol: Hz) is the unit of frequency in the International System of Units (SI), equivalent to one event (or cycle) per second. The hertz is an SI derived unit whose expression in terms of SI base units is s−1, meaning that one hertz is the reciprocal of one second.';
	const base = 't**-1';
}
?>