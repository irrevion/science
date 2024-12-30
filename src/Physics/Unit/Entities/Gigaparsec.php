<?php
namespace irrevion\science\Physics\Unit\Entities;

class Gigaparsec implements Length, NonStandard {
	const name = 'gigaparsec';
	const short_name = 'Gpc';
	// const category = 'length'; // defined by interface
	// const unit_system = 'NonStandard'; // defined by interface
	const measure = 'Gpc';
	const reference = 3.0856775814913673e25;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = 'One gigaparsec (Gpc) is one billion parsecs — one of the largest units of length commonly used. One gigaparsec is about 3.26 billion ly, or roughly 1/14 of the distance to the horizon of the observable universe (dictated by the cosmic microwave background radiation). Astronomers typically use gigaparsecs to express the sizes of large-scale structures such as the size of, and distance to, the CfA2 Great Wall; the distances between galaxy clusters; and the distance to quasars.'; // https://en.wikipedia.org/wiki/Parsec#Megaparsecs_and_gigaparsecs
	const base = '';
}
?>