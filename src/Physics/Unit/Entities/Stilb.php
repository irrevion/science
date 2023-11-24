<?php
namespace irrevion\science\Physics\Unit\Entities;

class Stilb implements Brightness, CGS {
	const name = 'stilb';
	const short_name = 'sb';
	// const category = 'brightness'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'sb';
	const reference = 10000;
	const reference_measure = 'nt';
	const alias = 'Lv';
	const descr = 'The stilb (sb) is the CGS unit of luminance for objects that are not self-luminous. It is equal to one candela per square centimeter or 104 nits. The name was coined by the French physicist André Blondel around 1920. It comes from the Greek word stilbein (στίλβειν), meaning \'to glitter\'.';
	const base = 'L**−2 * J';
}
?>