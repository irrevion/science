<?php
namespace irrevion\science\Physics\Unit\Entities;

use irrevion\science\Math\Math;

class Bril implements Brightness, NonStandard {
	const name = 'bril';
	const short_name = 'bril';
	// const category = 'brightness'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'bril';
	const reference = 1 / ( Math::PI * 1e7 );
	const reference_measure = 'nt';
	const alias = 'Lv';
	const descr = 'The bril is an obsolete unit of luminance.';
	const base = 'L**−2 * J';
}
?>