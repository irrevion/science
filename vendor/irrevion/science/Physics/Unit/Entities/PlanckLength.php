<?php
namespace irrevion\science\Physics\Unit\Entities;

class PlanckLength implements Length, Planck {
	const name = 'Planck length';
	const short_name = 'lp';
	// const category = 'length'; // defined by interface
	// const unit_system = 'Planck'; // defined by interface
	const measure = 'ℓₚ';
	const reference = 1.616255e-35;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = 'The Planck length ( ℓₚ = √ ℏG / c³ ) is equal to 1.616255(18)×10^−35 m (the two digits enclosed by parentheses are the estimated standard error associated with the reported numerical value) or about 10−20 times the diameter of a proton.';
	const base = '';
}
?>