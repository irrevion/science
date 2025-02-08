<?php
namespace irrevion\science\Physics\Unit\Entities;

class Siemens implements ElectricalConductance, SI {
	const name = 'siemens';
	const short_name = 'siemens';
	// const category = 'electrical_conductance'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'S';
	const reference = 1;
	const reference_measure = 'S';
	const alias = 'G';
	const descr = 'The siemens (symbol: S) is the unit of electric conductance, electric susceptance, and electric admittance in the International System of Units (SI). Conductance, susceptance, and admittance are the reciprocals of resistance, reactance, and impedance respectively; hence one siemens is equal to the reciprocal of one ohm (Ω**−1) and is also referred to as the mho. The siemens was adopted by the IEC in 1935, and the 14th General Conference on Weights and Measures approved the addition of the siemens as a derived unit in 1971.';
	// https://en.wikipedia.org/wiki/Siemens_(unit)
	const base = 'M**-1L**-2T**3I**2';
}
?>