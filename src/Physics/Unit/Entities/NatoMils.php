<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Math\Math;

class NatoMils implements Angle, NonStandard {
	const name = 'NATO mils';
	const short_name = 'mil (NATO)';
	// const category = 'angle'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'mil (NATO)';
	const reference = Math::TAU/6400;
	const reference_measure = 'RAD';
	const alias = '∠φ';
	const descr = 'There are also other definitions used for land mapping and artillery which are rounded to more easily be divided into smaller parts for use with compasses, which are then often referred to as "mils", "lines", or similar. For instance there are artillery sights and compasses with 6,400 NATO mils, 6,000 Warsaw Pact mils or 6,300 Swedish "streck" per turn instead of 360° or 2π radians, achieving higher resolution than a 360° compass while also being easier to divide into parts than if true milliradians were used.';
	const base = 'A';
}
?>