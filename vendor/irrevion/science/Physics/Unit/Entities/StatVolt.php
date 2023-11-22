<?php
namespace irrevion\science\Physics\Unit\Entities;

class StatVolt implements ElectricTension, CGS {
	const name = 'statvolt';
	const short_name = 'statV';
	// const category = 'electric_tension'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'statV';
	const reference = 299.792458;
	const reference_measure = 'V';
	const alias = 'U';
	const descr = 'The statvolt is a unit of voltage and electrical potential used in the CGS-ESU and gaussian systems of units. In terms of its relation to the SI units, one statvolt corresponds to ccgs 10−8 volt, i.e. to 299.792458 volts.';
	const base = '';
}
?>