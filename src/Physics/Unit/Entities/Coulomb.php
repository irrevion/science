<?php
namespace irrevion\science\Physics\Unit\Entities;

class Coulomb implements ElectricCharge, SI {
	const name = 'coulomb';
	const short_name = 'C';
	// const category = 'electric_charge'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'C';
	const reference = 1;
	const reference_measure = 'C';
	const alias = 'C';
	const descr = 'The coulomb (symbol: C) is the unit of electric charge in the International System of Units (SI). In the present version of the SI it is equal to the electric charge delivered by a 1 ampere constant current in 1 second and to 5×1027 / 801088317 elementary charges, e, (about 6.241509×1018 e).';
	const base = 'I*T';
}
?>