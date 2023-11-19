<?php
namespace irrevion\science\Physics\Unit\Entities;

class PlanckTime implements Time, Planck {
	const name = 'Planck time';
	const short_name = 'tp';
	// const category = 'time'; // defined by interface
	// const unit_system = 'Planck'; // defined by interface
	const measure = 'tₚ';
	const reference = 5.391180178e-44;
	const reference_measure = 's';
	const alias = 't';
	const descr = 'The Planck time tP is the time required for light to travel a distance of 1 Planck length in vacuum, which is a time interval of approximately 5.39×10−44 s. No current physical theory can describe timescales shorter than the Planck time, such as the earliest events after the Big Bang. Some conjecture states that the structure of time need not remain smooth on intervals comparable to the Planck time.';
	const base = '';
}
?>