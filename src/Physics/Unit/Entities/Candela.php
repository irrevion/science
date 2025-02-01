<?php
namespace irrevion\science\Physics\Unit\Entities;

class Candela implements LuminousIntensity, SI {
	const name = 'candela';
	const short_name = 'cd';
	// const category = 'luminous_intensity'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'cd';
	const reference = 1;
	const reference_measure = 'cd';
	const alias = 'Iᵥ';
	const descr = 'The luminous intensity, in a given direction, of a source that emits monochromatic radiation of frequency 5.4×10^14 hertz and that has a radiant intensity in that direction of 1/683 watt per steradian.';
	const base = 'J';
}
?>