<?php
namespace irrevion\science\Physics\Unit\Entities;

class ElectronMass implements Mass, NonStandard {
	const name = 'electron mass';
	const short_name = 'me';
	// const category = 'mass'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'me';
	const reference = 9.1093837015e-31;
	const reference_measure = 'kg';
	const alias = 'm';
	const descr = 'In particle physics, the electron mass (symbol: me) is the mass of a stationary electron, also known as the invariant mass of the electron. It is one of the fundamental constants of physics. It has a value of about 9.109×10−31 kilograms or about 5.486×10−4 daltons, which has an energy-equivalent of about 8.187×10−14 joules or about 0.511 MeV.';
	const base = '';
}
?>