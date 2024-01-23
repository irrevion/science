<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Math\Math;

class Apostilb implements Brightness, NonStandard {
	const name = 'apostilb';
	const short_name = 'asb';
	// const category = 'brightness'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'asb';
	const reference = 1/Math::PI;
	const reference_measure = 'nt';
	const alias = 'Lv';
	const descr = 'The apostilb is an obsolete unit of luminance. The SI unit of luminance is the candela per square metre (cd * m**-2). In 1942 Parry Moon proposed to rename the apostilb the blondel, after the French physicist André Blondel. The symbol for the apostilb is asb.';
	const base = 'L**−2 * J';
}
?>