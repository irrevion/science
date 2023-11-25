<?php
namespace irrevion\science\Physics\Unit\Entities;

class Caesium133 implements Frequency, SI {
	const name = 'caesium-133 hyperfine splitting in the ground state';
	const short_name = 'caesium133 νhfs';
	// const category = 'frequency'; // defined by interface
	// const unit_system = 'SI'; // defined by interface
	const measure = 'νhfs Cs';
	const reference = 9192631770;
	const reference_measure = 'Hz';
	const alias = 'ν';
	const descr = 'The International Committee for Weights and Measures defined the second as "the duration of 9192631770 periods of the radiation corresponding to the transition between the two hyperfine levels of the ground state of the caesium-133 atom" and then adds: "It follows that the hyperfine splitting in the ground state of the caesium 133 atom is exactly 9192631770 hertz, νhfs Cs = 9192631770 Hz." The dimension of the unit hertz is 1/time (T−1). Expressed in base SI units, the unit is the reciprocal second (1/s).';
	const base = 't**-1';
}
?>