<?php
namespace irrevion\science\Physics\Unit\Entities;

class Angstrom implements Length, NonStandard {
	const name = 'angstrom';
	const short_name = 'Å';
	// const category = 'length'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'Å';
	const reference = 1e-10;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = 'Angstrom (Å), unit of length, equal to 10^−10 metre, or 0.1 nanometre. It is used chiefly in measuring wavelengths of light. (Visible light stretches from 4000 to 7000 Å.) It is named for the 19th-century Swedish physicist Anders Jonas Ångström. The angstrom is also used to measure such quantities as atomic and molecular sizes (most elements have atoms with radii of about 1 to 2 Å) and the thickness of films on liquids.';
	// https://www.britannica.com/science/angstrom
	const base = '';
}
?>