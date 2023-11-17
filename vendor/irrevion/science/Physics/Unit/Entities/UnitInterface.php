<?php
namespace irrevion\science\Physics\Unit\Entities;

interface UnitInterface {
	const name = 0; // name of unit (kilogram, litre, electronvolt, calorie)
	const short_name = 0; // short name (kg, l, eV, cal)
	const category = 0; // application area (mass, volume, energy, energy)
	// const unit_system = 0; // system of units (SI, NonStandard, NonStandard, NonStandard)
	const measure = 0; // unit symbol or postfix (kg, l, eV, cal)
	const reference = 0; // value expressed in SI (1, 1e-2, 1.602176634e-19, 4.184)
	const reference_measure = 0; // kg, m³, J, J
	const alias = 0; // how is expresses in formulas (m, V, E, E)
	const descr = 0; // human readable definition of unit
	const base = 0; // https://en.wikipedia.org/wiki/Dimensional_analysis
}
?>