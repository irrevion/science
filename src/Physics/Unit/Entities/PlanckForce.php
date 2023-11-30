<?php
namespace irrevion\science\Physics\Unit\Entities;

class PlanckForce implements Force, Planck {
	const name = 'Planck force';
	const short_name = 'mₚ';
	// const category = 'force'; // defined by interface
	// const unit_system = 'Planck'; // defined by interface
	const measure = 'mₚ';
	const reference = 1.2103e44;
	const reference_measure = 'N';
	const alias = 'F';
	const descr = 'The Planck unit of force may be thought of as the derived unit of force in the Planck system if the Planck units of time, length, and mass are considered to be base units. It is the gravitational attractive force of two bodies of 1 Planck mass each that are held 1 Planck length apart.';
	const base = 'LMT**-2';
}
?>