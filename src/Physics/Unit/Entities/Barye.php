<?php
namespace irrevion\science\Physics\Unit\Entities;

class Barye implements Pressure, CGS {
	const name = 'barye';
	const short_name = 'Ba';
	// const category = 'pressure'; // defined by interface
	// const unit_system = 'CGS'; // defined by interface
	const measure = 'Ba';
	const reference = 0.1;
	const reference_measure = 'Pa';
	const alias = 'P';
	const descr = 'The barye (symbol: Ba), or sometimes barad, barrie, bary, baryd, baryed, or barie, is the centimetre–gram–second (CGS) unit of pressure. It is equal to 1 dyne per square centimetre.';
	const base = 'M*L**-1*T**-2';
}
?>