<?php
namespace irrevion\science\Physics\Unit\Entities;

class Volt implements ElectricTension, SI {
	const name = 'volt';
	const short_name = 'V';
	// const category = 'electric_tension'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'V';
	const reference = 1;
	const reference_measure = 'V';
	const alias = 'U';
	const descr = 'The "international volt" was defined in 1893 as 1/1.434 of the emf of a Clark cell. This definition was abandoned in 1908 in favor of a definition based on the international ohm and international ampere until the entire set of "reproducible units" was abandoned in 1948. A redefinition of SI base units, including defining the value of the elementary charge, took effect on 20 May 2019.';
	const base = 'M L2 T−3 I−1';
}
?>