# Quantity

Quantity is a physical entity representing its value as measured amount of physical parameter in specified units system:
```php
use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Entities\Quantity;
use irrevion\science\Physics\Unit\Categories;
use irrevion\science\Physics\Unit\{SI, Planck, IAU, CGS, Natural, NonStandard, Imperial, USC};

$S_pc = new Quantity(12, IAU::parsec);
$S_ly = $S_pc->convert(IAU::light_year);
```

All supported measure units (available at `irrevion\science\Physics\Unit\Categories::list`) are listed below:
```php
const list = [
	'angle' => [
		'arcminute' => 'Entities\ArcMinute', // NonStandard::arcminute
		'arcsecond' => 'Entities\ArcSecond', // NonStandard::arcsecond
		'degree' => 'Entities\Degree', // NonStandard::degree
		'gon' => 'Entities\Gradian', // NonStandard::grad
		'grad' => 'Entities\Gradian', // NonStandard::grad
		'mas' => 'Entities\MilliArcSecond', // NonStandard::milliarcsecond
		'microarcsecond' => 'Entities\MicroArcSecond', // NonStandard::microarcsecond
		'mil' => 'Entities\MilliRadian', // NonStandard::mrad
		'milliarcsecond' => 'Entities\MilliArcSecond', // NonStandard::milliarcsecond
		'milliradian' => 'Entities\MilliRadian', // NonStandard::mrad
		'mrad' => 'Entities\MilliRadian', // NonStandard::mrad
		'nanoradian' => 'Entities\NanoRadian',
		'nato_mils' => 'Entities\NatoMils',
		'nrad' => 'Entities\NanoRadian',
		'radian' => 'Entities\Radian',
		'turn' => 'Entities\Turn',
		'ussr_mrad' => 'Entities\UssrMrad'
	],
	'angular_square' => [
		'steradian' => 'Entities\Steradian',
		'spat' => 'Entities\Spat',
		'square_degree' => 'Entities\SquareDegree',
		'square_arcminute' => 'Entities\SquareArcMinute',
		'square_arcsecond' => 'Entities\SquareArcSecond'
	],
	'brightness' => [
		'apostilb' => 'Entities\Apostilb', // NonStandard::apostilb
		'candela_per_square_metre' => 'Entities\Nit',
		'nit' => 'Entities\Nit',
		'stilb' => 'Entities\Stilb',
	],
	'capacitance' => [
		'abfarad' => 'Entities\AbFarad',
		'farad' => 'Entities\Farad',
	],
	'electric_charge' => [
		'coulomb' => 'Entities\Coulomb',
		'C' => 'Entities\Coulomb',
		'elementary_charge' => 'Entities\ElementaryCharge',
		'e' => 'Entities\ElementaryCharge',
	],
	'electric_current' => [
		'abampere' => 'Entities\AbAmpere',
		'ampere' => 'Entities\Ampere',
		'statampere' => 'Entities\StatAmpere',
	],
	'electric_tension' => [
		'statvolt' => 'Entities\StatVolt',
		'volt' => 'Entities\Volt',
	],
	'electrical_resistance' => [
		'abohm' => 'Entities\AbOhm',
		'ohm' => 'Entities\Ohm',
		'statohm' => 'Entities\StatOhm',
	],
	'energy' => [
		'electron_volt' => 'Entities\ElectronVolt',
		'eV' => 'Entities\ElectronVolt', // Natural::eV
		'hartree' => 'Entities\HartreeEnergy', // Natural::hartree
		'joule' => 'Entities\Joule',
		'J' => 'Entities\Joule', // SI::J
		'planck_energy' => 'Entities\PlanckEnergy', // Planck::energy, Natural::planck_energy
		'Ry' => 'Entities\RydbergEnergy', // NonStandard::Ry
		'rydberg' => 'Entities\RydbergEnergy', // NonStandard::rydberg_energy
		'watt_second' => 'Entities\Joule',
	],
	'force' => [
		'au_force' => 'Entities\HartreeForce',
		'hartree_force' => 'Entities\HartreeForce',
		'newton' => 'Entities\Newton',
		'N' => 'Entities\Newton',
		'planck_force' => 'Entities\PlanckForce',
	],
	'frequency' => [
		'caesium133' => 'Entities\Caesium133',
		'hertz' => 'Entities\Hertz',
		'Hz' => 'Entities\Hertz',
	],
	'length' => [
		'astronomical_unit' => 'Entities\AstronomicalUnit',
		'au' => 'Entities\AstronomicalUnit',
		'light_year' => 'Entities\LightYear',
		'ly' => 'Entities\LightYear',
		'metre' => 'Entities\Metre',
		'parsec' => 'Entities\Parsec',
		'planck_length' => 'Entities\PlanckLength',
	],
	'luminous_intensity' => [
		'candela' => 'Entities\Candela',
	],
	'mass' => [
		'AMU' => 'Entities\Dalton', // NonStandard::AMU
		'atomic_mass_unit' => 'Entities\Dalton', // NonStandard::AMU
		'dalton' => 'Entities\Dalton', // NonStandard::dalton
		'electron_mass' => 'Entities\ElectronMass',
		'kilogram' => 'Entities\Kilogram',
		'kg' => 'Entities\Kilogram',
		'pound' => 'Entities\Pound',
		'solar_mass' => 'Entities\SolarMass',
	],
	'power' => [
		'abwatt' => 'Entities\ErgsPerSecond',
		'ergs_per_second' => 'Entities\ErgsPerSecond',
		'watt' => 'Entities\Watt',
		'W' => 'Entities\Watt',
	],
	'pressure' => [
		'barye' => 'Entities\Barye',
		'pascal' => 'Entities\Pascal',
		'Pa' => 'Entities\Pascal',
	],
	'substance_amount' => [
		'mole' => 'Entities\Mole',
		'particle' => 'Entities\Particle',
	],
	'temperature' => [
		'celsius' => 'Entities\Celsius',
		'fahrenheit' => 'Entities\Fahrenheit',
		'kelvin' => 'Entities\Kelvin',
		'K' => 'Entities\Kelvin',
		'rankine' => 'Entities\Rankine',
	],
	'time' => [
		'planck_time' => 'Entities\PlanckTime',
		'second' => 'Entities\Second',
		'year' => 'Entities\Year',
	],
];
```
> [!NOTE]
> Some units can have aliases for better usability.
> Some units can be represented in more than one units system.