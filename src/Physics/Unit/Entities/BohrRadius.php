<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Physics\Physics;

class BohrRadius implements Length, Natural {
	const name = 'Bohr radius';
	const short_name = 'a₀';
	// const category = 'length'; // defined by interface
	// const unit_system = 'Natural'; // defined by interface
	const measure = 'rB';
	const reference = Physics::BOHR_RADIUS;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = 'The Bohr radius a₀ is a physical constant, approximately equal to the most probable distance between the nucleus and the electron in a hydrogen atom in its ground state. It is named after Niels Bohr, due to its role in the Bohr model of an atom. Its value is 5.29177210544(82)×10−11 m.';
	const base = '';
}
?>