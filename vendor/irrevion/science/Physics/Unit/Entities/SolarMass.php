<?php
namespace irrevion\science\Physics\Unit\Entities;

class SolarMass implements Mass, IAU {
	const name = 'solar mass';
	const short_name = 'M☉';
	// const category = 'mass'; // defined by interface
	// const unit_system = 'IAU'; // defined by interface
	const measure = 'M☉';
	const reference = 1.98847e30;
	const reference_measure = 'kg';
	const alias = 'm';
	const descr = 'The solar mass (M☉) is a standard unit of mass in astronomy, equal to approximately 2×10^30 kg. It is approximately equal to the mass of the Sun. It is often used to indicate the masses of other stars, as well as stellar clusters, nebulae, galaxies and black holes.';
	const base = '';
}
?>