<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Math\Math;

class Gradian implements Angle, NonStandard {
	const name = 'gradian';
	const short_name = 'grad';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'grad';
	const reference = Math::PI/200;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'In trigonometry, the gradian – also known as the gon (from Ancient Greek γωνία (gōnía) \'angle\'), grad, or grade – is a unit of measurement of an angle, defined as one-hundredth of the right angle; in other words, 100 gradians is equal to 90 degrees. It is equivalent to 1/400 of a turn, 9/10 of a degree, or π/200 of a radian. Measuring angles in gradians is said to employ the centesimal system of angular measurement, initiated as part of metrication and decimalisation efforts.';
	const base = 'A';
}
?>