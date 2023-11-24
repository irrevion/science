<?php
namespace irrevion\science\Physics\Unit\Entities;

class Pound implements Mass, Imperial {
	const name = 'pound';
	const short_name = 'lb';
	// const category = 'mass'; // defined by interface
	// const unit_system = 'Imperial'; // defined by interface
	const measure = 'lb';
	const reference = 0.45359237;
	const reference_measure = 'kg';
	const alias = 'm';
	const descr = 'The pound or pound-mass is a unit of mass used in both the British imperial and United States customary systems of measurement. Various definitions have been used; the most common today is the international avoirdupois pound, which is legally defined as exactly 0.45359237 kilograms, and which is divided into 16 avoirdupois ounces.';
	const base = '';
}
?>