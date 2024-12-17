<?php
namespace irrevion\science\Physics\Unit\Entities;

class RydbergWavelength implements Length, NonStandard {
	const name = 'Rydberg wavelength';
	const short_name = 'R∞^-1';
	// const category = 'length'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'Rydberg wavelengths';
	const reference = 9.112670505826e-8;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = 'Rydberg wavelength is a reciprocal of Rydberg constant.';
	const base = '';
}
?>