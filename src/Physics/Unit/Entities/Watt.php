<?php
namespace irrevion\science\Physics\Unit\Entities;

class Watt implements Power, SI {
	const name = 'watt';
	const short_name = 'W';
	// const category = 'power'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'W';
	const reference = 1;
	const reference_measure = 'W';
	const alias = 'P';
	const descr = 'The watt (symbol: W) is the unit of power or radiant flux in the International System of Units (SI), equal to 1 joule per second or 1 kg⋅m2⋅s−3. It is used to quantify the rate of energy transfer.';
	const base = 'L**2*M*T***-3';
}
?>