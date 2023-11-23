<?php
namespace irrevion\science\Physics\Unit\Entities;

class Nit implements Brightness, SI {
	const name = 'nit';
	const short_name = 'nt';
	// const category = 'brightness'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'nt';
	const reference = 1;
	const reference_measure = 'nt';
	const alias = 'Iᵥ';
	const descr = 'The Nit (candela per square metre, symbol: cd/m2) is the unit of brightness (luminance) in the International System of Units (SI). The unit is based on the candela, the SI unit of luminous intensity, and the square metre, the SI unit of area. The term nit is believed to come from the Latin word nitēre, "to shine". As a measure of light emitted per unit area, this unit is used to specify the brightness of a display device. The sRGB spec for monitors targets 80 cd/m2. Typically, monitors calibrated for SDR broadcast or studio color grading should have a brightness of 100 cd/m2.[4] Most consumer desktop liquid crystal displays have luminances of 200 to 300 cd/m2. HDR displays range from 450 to above 1600 cd/m2.';
	const base = 'L**−2 * J';
}
?>