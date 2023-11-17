<?php
namespace irrevion\science\Physics\Unit;

enum SI: string {
	// 7 base units
	case length = 'metre';
	case time = 'second';
	case mass = 'kilogram';
	case current = 'ampere';
	case temperature = 'kelvin';
	case amount = 'mole';
	case luminous_intensity = 'candela';

	public function reference(): int {
		// unit quantity relative to SI International System of Units for conversion
		return 1;
	}

	public function unit(): string {
		// measuring unit full name
		return match($this) {
			default => $this->value
		};
	}

	public function measure(): string {
		// measuring unit short name
		return match($this) {
			SI::length => 'm',
			SI::mass => 'kg',
			SI::time => 's',
		};
	}

	public function alias(): string {
		// measuring unit short name
		return match($this) {
			SI::length => 'L',
			SI::mass => 'm',
			SI::time => 't',
		};
	}

	public function descr(): string {
		// measuring unit short name
		return match($this) {
			SI::length => 'The distance travelled by light in vacuum in 1/299792458 seconds.',
			SI::mass => 'The kilogram is defined by setting the Planck constant h exactly to 6.62607015×10−34 J⋅s (J = kg⋅m2⋅s−2), given the definitions of the metre and the second.',
			SI::time => 'The duration of 9192631770 periods of the radiation corresponding to the transition between the two hyperfine levels of the ground state of the caesium-133 atom.',
		};
	}
}
?>