<?php
namespace irrevion\science\Physics\Unit\Entities;

class StatOhm implements ElectricalResistance, CGS {
	const name = 'statohm';
	const short_name = 'statΩ';
	// const category = 'electrical_resistance'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'statΩ';
	const reference = 8.987551787e11;
	const reference_measure = 'Ω';
	const alias = 'R';
	const descr = 'The statohm is the unit of electrical resistance in the electrostatic system of units which was part of the CGS system of units based upon the centimetre, gram and second.';
	const base = 'M*L**2*T**-3*I**-2';
}
?>