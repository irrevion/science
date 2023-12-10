<?php
namespace irrevion\science\Physics\Unit\Entities;

class AbOhm implements ElectricalResistance, CGS {
	const name = 'abohm';
	const short_name = 'abΩ';
	// const category = 'electrical_resistance'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'abΩ';
	const reference = 1e-9;
	const reference_measure = 'Ω';
	const alias = 'R';
	const descr = 'The abohm is the derived unit of electrical resistance in the emu-cgs (centimeter-gram-second) system of units (emu stands for "electromagnetic units"). One abohm corresponds to 10−9 ohms in the SI system of units, which is a nanoohm.';
	const base = 'M*L**2*T**-3*I**-2';
}
?>