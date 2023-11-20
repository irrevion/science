<?php
namespace irrevion\science\Physics\Unit\Entities;

class Mole implements SubstanceAmount, SI {
	const name = 'mole';
	const short_name = 'mol';
	// const category = 'substance_amount'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'mole';
	const reference = 1;
	const reference_measure = 'mole';
	const alias = 'n';
	const descr = 'The amount of substance of exactly 6.02214076×10**23 elementary entities. This number is the fixed numerical value of the Avogadro constant, Na, when expressed in the unit mol**−1.';
	const base = 'N';
}
?>