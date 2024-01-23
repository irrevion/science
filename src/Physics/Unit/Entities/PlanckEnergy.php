<?php
namespace irrevion\science\Physics\Unit\Entities;

class PlanckEnergy implements Energy, Planck {
	const name = 'Planck energy';
	const short_name = 'Eₚ';
	// const category = 'energy'; // defined by interface
	// const unit_system = 'Planck'; // defined by interface
	const measure = 'Eₚ';
	const reference = 1.96e9;
	const reference_measure = 'J';
	const alias = 'Eₚ';
	const descr = 'The Planck energy is the unit of energy in the system of Planck units.';
	const base = '';
}
?>