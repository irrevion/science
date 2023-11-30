<?php
namespace irrevion\science\Physics\Unit\Entities;

class HartreeForce implements Force, Natural {
	const name = 'Hartree force';
	const short_name = 'eV·Å⁻¹';
	// const category = 'force'; // defined by interface
	// const unit_system = 'Natural'; // defined by interface
	const measure = 'eV·Å⁻¹';
	const reference = 8.2387234983e-8;
	const reference_measure = 'N';
	const alias = 'F';
	const descr = 'Atomic units are chosen to reflect the properties of electrons in atoms, which is particularly clear in the classical Bohr model of the hydrogen atom for the bound electron in its ground state: electrical attractive force (due to nucleus) = 1 a.u. of force';
	const base = 'LMT**-2';
}
?>