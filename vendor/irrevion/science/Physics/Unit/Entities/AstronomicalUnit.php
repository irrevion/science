<?php
namespace irrevion\science\Physics\Unit\Entities;

class AstronomicalUnit implements Length, IAU {
	const name = 'astronomical unit';
	const short_name = 'AU';
	// const category = 'length'; // defined by interface
	// const unit_system = 'IAU'; // defined by interface
	const measure = 'au';
	const reference = 149597870700;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = 'The astronomical unit (symbol: au, or AU) is a unit of length, roughly the distance from Earth to the Sun and approximately equal to 150 million kilometres (93 million miles) or 8.3 light-minutes. The actual distance from Earth to the Sun varies by about 3% as Earth orbits the Sun, from a maximum (aphelion) to a minimum (perihelion) and back again once each year. The astronomical unit was originally conceived as the average of Earth`s aphelion and perihelion; however, since 2012 it has been defined as exactly 149597870700 m.';
	const base = '';
}
?>