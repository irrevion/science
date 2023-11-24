<?php
namespace irrevion\science\Physics\Unit\Entities;

class Joule implements Energy, SI {
	const name = 'joule';
	const short_name = 'J';
	// const category = 'energy'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'J';
	const reference = 1;
	const reference_measure = 'J';
	const alias = 'E';
	const descr = 'The joule is the unit of energy in the International System of Units (SI). It is equal to the amount of work done when a force of 1 newton displaces a mass through a distance of 1 metre in the direction of the force applied. It is also the energy dissipated as heat when an electric current of one ampere passes through a resistance of one ohm for one second.';
	const base = 'J';
}
?>