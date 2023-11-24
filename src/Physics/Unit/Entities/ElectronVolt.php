<?php
namespace irrevion\science\Physics\Unit\Entities;

class ElectronVolt implements Energy, NonStandard {
	const name = 'electronvolt';
	const short_name = 'eV';
	// const category = 'energy'; // defined by interface
	// const unit_system = 'NonStandart'; // defined by interface
	const measure = 'eV';
	const reference = 1.602176634e-19;
	const reference_measure = 'J';
	const alias = 'E';
	const descr = 'In physics, an electronvolt (symbol eV, also written electron-volt and electron volt) is the measure of an amount of kinetic energy gained by a single electron accelerating from rest through an electric potential difference of one volt in vacuum. When used as a unit of energy, the numerical value of 1 eV in joules (symbol J) is equivalent to the numerical value of the charge of an electron in coulombs (symbol C). Under the 2019 redefinition of the SI base units, this sets 1 eV equal to the exact value 1.602176634×10−19 J.';
	const base = 'J';
}
?>