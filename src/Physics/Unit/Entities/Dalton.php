<?php
namespace irrevion\science\Physics\Unit\Entities;

class Dalton implements Mass, NonStandard {
	const name = 'Dalton';
	const short_name = 'Da';
	// const category = 'mass'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'Da';
	// const reference = 1.6605390666e-27; // https://en.wikipedia.org/wiki/Dalton_(unit)
	const reference = 1.660538921e-27; // https://www.britannica.com/science/atomic-mass-unit
	const reference_measure = 'kg';
	const alias = 'm';
	const descr = 'Atomic mass unit (AMU), in physics and chemistry, a unit for expressing masses of atoms, molecules, or subatomic particles. An atomic mass unit is equal to 1/12 the mass of a single atom of carbon-12, the most abundant isotope of carbon, or 1.660538921 × 10 −24 gram. The mass of an atom consists of the mass of the nucleus plus that of the electrons, so the atomic mass unit is not exactly the same as the mass of the proton or neutron. Atomic mass units are also called daltons (Da), for chemist John Dalton.';
	const base = 'M';
}
?>