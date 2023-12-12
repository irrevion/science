<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Physics\Physics;

class Particle implements SubstanceAmount, Natural {
	const name = 'particle(s)';
	const short_name = 'particle';
	// const category = 'substance_amount'; // defined by interface
	// const unit_system = 'Natural'; // defined by interface
	const measure = 'particles';
	const reference = 1/Physics::AVOGADRO;
	const reference_measure = 'mole';
	const alias = 'n';
	const descr = 'One elementary entity of substance.';
	const base = 'N';
}
?>