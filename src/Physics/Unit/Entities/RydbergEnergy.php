<?php
namespace irrevion\science\Physics\Unit\Entities;

class RydbergEnergy implements Energy, NonStandard {
	const name = 'Rydberg energy';
	const short_name = 'Ry';
	// const category = 'energy'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'Ry';
	const reference = 2.1798723611035e-18;
	const reference_measure = 'J';
	const alias = 'Eᵣ';
	const descr = 'The Rydberg (or Rydberg unit of energy) is the ionization energy of hydrogen in its ground state, which is around 13.6 eV, currently calculated to be 13.605693122994 eV and 2.1798723611035 × 10**-18 joules. The Rydberg constant is this value divided by hc, the Planck constant (h) times the speed of light in a vacuum (c).';
	const base = 'M * L**2 * T**-2';
}
?>