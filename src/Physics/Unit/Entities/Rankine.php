<?php
namespace irrevion\science\Physics\Unit\Entities;

class Rankine implements Temperature, NonStandard {
	const name = 'rankine';
	const short_name = 'R';
	// const category = 'temperature'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = '°R';
	const reference = 0.55555555555556;
	const reference_measure = 'K';
	const alias = 'T';
	const descr = 'The Rankine scale is an absolute scale of thermodynamic temperature named after the University of Glasgow engineer and physicist Macquorn Rankine, who proposed it in 1859. Similar to the Kelvin scale, which was first proposed in 1848, zero on the Rankine scale is absolute zero, but a temperature difference of one Rankine degree (°R or °Ra) is defined as equal to one Fahrenheit degree, rather than the Celsius degree used on the Kelvin scale. In converting from kelvin to degrees Rankine, 1 K = 9/5 °R or 1 K = 1.8 °R. A temperature of 0 K (−273.15 °C; −459.67 °F) is equal to 0 °R.';
	const base = '';
}
?>