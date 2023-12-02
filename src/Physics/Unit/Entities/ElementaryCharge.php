<?php
namespace irrevion\science\Physics\Unit\Entities;

class ElementaryCharge implements ElectricCharge, Natural {
	const name = 'elementary charge';
	const short_name = 'e';
	// const category = 'electric_charge'; // defined by interface
	// const unit_system = 'Natural'; // defined by interface
	const measure = 'e';
	const reference = 1.602176634e-19;
	const reference_measure = 'C';
	const alias = 'C';
	const descr = 'The elementary charge, usually denoted by e, is a fundamental physical constant, defined as the electric charge carried by a single proton or, equivalently, the magnitude of the negative electric charge carried by a single electron, which has charge −1 e.';
	const base = 'I*T';
}
?>