<?php
namespace irrevion\science\Physics\Unit\Entities;

class HallConductance implements ElectricalConductance, NonStandard {
	const name = 'quantum Hall conductance';
	const short_name = 'Hall conductance';
	// const category = 'electrical_conductance'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'QHC';
	const reference = 7.748091729e-5;
	const reference_measure = 'S';
	const alias = 'G';
	const descr = 'Quantum Hall conductance appears when measuring the conductance of a quantum point contact, and, more generally, is a key component of the Landauer formula, which relates the electrical conductance of a quantum conductor to its quantum properties. It is twice the reciprocal of the von Klitzing constant (2/RK).';
	const base = 'M**-1L**-2T**3I**2';
}
?>