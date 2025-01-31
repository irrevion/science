<?php
namespace irrevion\science\Physics\Unit\Entities;

class StatFarad implements Capacitance, CGS {
	const name = 'statfarad';
	const short_name = 'statF';
	// const category = 'capacitance'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'statF';
	const reference = 1.112650056e-12;
	const reference_measure = 'F';
	const alias = '⊣❪―';
	const descr = 'The statfarad (abbreviated statF) is a rarely used CGS unit equivalent to the capacitance of a capacitor with a charge of 1 statcoulomb across a potential difference of 1 statvolt. It is 1/(10^−5 c^2) farad, approximately 1.1126 picofarads.';
	const base = 'L**-2 * M**-1 * T**4 * I**2';
}
?>