<?php
namespace irrevion\science\Physics\Unit\Entities;

class LightYear implements Length, IAU {
	const name = 'light year';
	const short_name = 'l.y.';
	// const category = 'length'; // defined by interface
	// const unit_system = 'IAU'; // defined by interface
	const measure = 'ly';
	const reference = 9460730472580.8e3;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = 'A light-year, alternatively spelled light year, (ly) is a unit of length used to express astronomical distances and is equal to exactly 9,460,730,472,580.8 km, which is approximately 5.88 trillion mi. As defined by the International Astronomical Union (IAU), a light-year is the distance that light travels in a vacuum in one Julian year (365.25 days).';
	const base = '';
}
?>