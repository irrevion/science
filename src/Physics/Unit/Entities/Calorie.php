<?php
namespace irrevion\science\Physics\Unit\Entities;

class Calorie implements Energy, NonStandard {
	const name = 'calorie';
	const short_name = 'cal';
	// const category = 'energy'; // defined by interface
	// const unit_system = 'NonStandart'; // defined by interface
	const measure = 'cal';
	const reference = 4.184;
	const reference_measure = 'J';
	const alias = 'E';
	const descr = 'The term "calorie" comes from Latin calor ”heat„. It was first introduced by Nicolas Clément, as a unit of heat energy, in lectures on experimental calorimetry during the years 1819–1824.
	The precise equivalence between calories and joules has varied over the years, but in thermochemistry and nutrition it is now generally assumed that one (small) calorie (thermochemical calorie) is equal to exactly 4.184 J, and therefore one kilocalorie (one large calorie) is 4184 J or 4.184 kJ.';
	const base = 'J';
}
?>