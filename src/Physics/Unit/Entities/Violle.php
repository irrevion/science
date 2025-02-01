<?php
namespace irrevion\science\Physics\Unit\Entities;

class Violle implements LuminousIntensity, NonStandard {
	const name = 'violle';
	const short_name = 'violle';
	// const category = 'luminous_intensity'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'violle';
	const reference = 20.17;
	const reference_measure = 'cd';
	const alias = 'Iᵥ';
	const descr = 'Standard for luminous intensity, called the Violle, equal to the light emitted by 1 cm² of platinum at its melting point. It was the first unit of light intensity that did not depend on the properties of a particular lamp. This was much larger than traditional measures such as candlepower, so the standard SI unit candela was originally defined in 1946 as 1/60 Violle.';
	const base = 'J';
}
?>