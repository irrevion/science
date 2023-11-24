<?php
namespace irrevion\science\Physics\Unit\Entities;

class Ampere implements ElectricCurrent, SI {
	const name = 'ampere';
	const short_name = 'A';
	// const category = 'electric_current'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'A';
	const reference = 1;
	const reference_measure = 'A';
	const alias = 'I';
	const descr = 'The flow of exactly 1/1.602176634×10^−19 times the elementary charge e per second. Equalling approximately 6.2415090744×10^18 elementary charges per second.';
	const base = 'I';
}
?>