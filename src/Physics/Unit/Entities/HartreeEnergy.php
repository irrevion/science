<?php
namespace irrevion\science\Physics\Unit\Entities;

class HartreeEnergy implements Energy, Natural {
	const name = 'hartree';
	const short_name = 'Eh';
	// const category = 'energy'; // defined by interface
	// const unit_system = 'Natural'; // defined by interface
	const measure = 'Eh';
	const reference = 4.3597447222071e-18;
	const reference_measure = 'J';
	const alias = 'Eh';
	const descr = 'The hartree (symbol: Eh or Ha), also known as the Hartree energy, is the unit of energy in the Hartree atomic units system, named after the British physicist Douglas Hartree. Its CODATA recommended value is Eh = 4.3597447222071(85)×10−18 J = 27.211386245988(53) eV.';
	const base = '';
}
?>