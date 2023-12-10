<?php
namespace irrevion\science\Physics\Unit\Entities;

class Ohm implements ElectricalResistance, SI {
	const name = 'ohm';
	const short_name = 'Ω';
	// const category = 'electrical_resistance'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'Ω';
	const reference = 1;
	const reference_measure = 'Ω';
	const alias = 'R';
	const descr = 'The ohm (symbol: Ω, the uppercase Greek letter omega) is the unit of electrical resistance in the International System of Units (SI). It is named after German physicist Georg Ohm. Various empirically derived standard units for electrical resistance were developed in connection with early telegraphy practice, and the British Association for the Advancement of Science proposed a unit derived from existing units of mass, length and time, and of a convenient scale for practical work as early as 1861.';
	const base = 'M*L**2*T**-3*I**-2';
}
?>