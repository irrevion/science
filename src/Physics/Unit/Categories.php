<?php
namespace irrevion\science\Physics\Unit;

use irrevion\science\Helpers\{Utils};


class Categories {

	const list = [
		'angle' => [
			'arcminute' => 'Entities\ArcMinute',  // NonStandard::arcminute
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
			// bril
			'candela_per_square_metre' => 'Entities\Nit', // SI::candela_per_square_metre
			// foot_lambert
			'nit' => 'Entities\Nit', // SI::nit
			// lambert
			// skot
			'stilb' => 'Entities\Stilb',
		],
		'capacitance' => [
			'abfarad' => 'Entities\AbFarad',
			'farad' => 'Entities\Farad',
			//'μF' => 'Entities\MicroFarad',
			//'pF' => 'Entities\PicoFarad',
			//'statfarad' => 'Entities\StatFarad',
		],
		'electric_charge' => [
			//'abcoulomb' => 'Entities\AbCoulomb',
			//'amper_hour' => 'Entities\AmperHour',
			//'Ah' => 'Entities\AmperHour',
			'coulomb' => 'Entities\Coulomb',
			'C' => 'Entities\Coulomb',
			'elementary_charge' => 'Entities\ElementaryCharge',
			'e' => 'Entities\ElementaryCharge',
			//'faraday' => 'Entities\Faraday',
			//'franklin' => 'Entities\StatCoulomb',
			//'mAh' => 'Entities\MilliAmperHour',
			//'statcoulomb' => 'Entities\StatCoulomb',
		],
		'electric_current' => [
			'abampere' => 'Entities\AbAmpere',
			'ampere' => 'Entities\Ampere',
			// elementary_charge_per_planck_time
			// elementary_charge_per_second
			'statampere' => 'Entities\StatAmpere',
		],
		'electric_tension' => [
			// abvolt
			'statvolt' => 'Entities\StatVolt',
			'volt' => 'Entities\Volt',
		],
		'electrical_resistance' => [
			'abohm' => 'Entities\AbOhm',
			'ohm' => 'Entities\Ohm',
			'statohm' => 'Entities\StatOhm',
		],
		'energy' => [
			// btu
			// calorie
			// coal_ton
			'electron_volt' => 'Entities\ElectronVolt',
			'eV' => 'Entities\ElectronVolt', // Natural::eV
			// erg
			// exajoule
			// foot_poundal
			// gigajoule
			'hartree' => 'Entities\HartreeEnergy', // Natural::hartree
			'joule' => 'Entities\Joule',
			'J' => 'Entities\Joule', // SI::J
			// kilocalorie
			// kcal
			// kilojoule
			// kilowatt_hour
			// kWh
			// mbtu
			'planck_energy' => 'Entities\PlanckEnergy', // Planck::energy, Natural::planck_energy
			// quad
			'Ry' => 'Entities\RydbergEnergy', // NonStandard::Ry
			'rydberg' => 'Entities\RydbergEnergy', // NonStandard::rydberg_energy
			// terawatt_year
			// therm
			'watt_second' => 'Entities\Joule',
		],
		'force' => [
			'au_force' => 'Entities\HartreeForce',
			//'dyne' => '',
			//'dyn' => '',
			'hartree_force' => 'Entities\HartreeForce',
			// lbf
			'newton' => 'Entities\Newton',
			'N' => 'Entities\Newton',
			'planck_force' => 'Entities\PlanckForce',
			// pound-force
			// sthene
		],
		'frequency' => [
			'caesium133' => 'Entities\Caesium133',
			// gigahertz
			'hertz' => 'Entities\Hertz',
			'Hz' => 'Entities\Hertz',
			// 'kilohertz' => 'Entities\KiloHertz',
			// 'kHz' => 'Entities\KiloHertz',
			// megahertz
			// 'rpm' => 'Entities\RevolutionPerMinute',
			// rydberg
			// terahertz
		],
		'length' => [
			'angstrom' => 'Entities\Angstrom',
			'astronomical_unit' => 'Entities\AstronomicalUnit',
			// attometre
			'au' => 'Entities\AstronomicalUnit',
			// bohr_radius
			// centimetre
			// chi
			// foot
			// inch
			'kilometer' => 'Entities\Kilometre',
			'kilometre' => 'Entities\Kilometre',
			'km' => 'Entities\Kilometre',
			'light_year' => 'Entities\LightYear',
			'ly' => 'Entities\LightYear',
			'metre' => 'Entities\Metre',
			'm' => 'Entities\Metre',
			// mikron
			// mile
			// millimetre
			// nanometre
			// nautical_mile
			'parsec' => 'Entities\Parsec',
			//'picometre' => 'Entities\Picometre',
			'planck_length' => 'Entities\PlanckLength',
			// rydberg wavelength
			// sm
			// yard
			// zhang
		],
		'luminous_intensity' => [
			'candela' => 'Entities\Candela',
		],
		'mass' => [
			'AMU' => 'Entities\Dalton',
			'atomic_mass_unit' => 'Entities\Dalton',
			// carat
			'dalton' => 'Entities\Dalton',
			// earth
			'electron_mass' => 'Entities\ElectronMass',
			// gongjin
			// gram
			// jin
			'kilogram' => 'Entities\Kilogram',
			'kg' => 'Entities\Kilogram',
			// liang
			// moon
			// ounce
			// planck mass
			'pound' => 'Entities\Pound',
			// slug
			'solar_mass' => 'Entities\SolarMass',
		],
		'power' => [
			'abwatt' => 'Entities\ErgsPerSecond',
			//'btu_per_hour' => 'Entities\BTUPerHour',
			//'calories_per_hour' => 'Entities\CaloriesPerHour',
			//'decibel_milliwats' => 'Entities\DecibelMilliwats',
			//'dBm' => 'Entities\DecibelMilliwats',
			'ergs_per_second' => 'Entities\ErgsPerSecond',
			//'footpounds_per_minute' => 'Entities\FootPoundsPerMinute',
			//'hartree_power' => 'Entities\HartreePower',
			//'horsepower' => 'Entities\HorsePower',
			//'hp' => 'Entities\HorsePower',
			//'tons_of_refrigeration' => 'Entities\TonsOfRefrigeration',
			'watt' => 'Entities\Watt',
			'W' => 'Entities\Watt',
		],
		'pressure' => [
			// atmosphere
			// bar
			'barye' => 'Entities\Barye',
			// EPa
			// GPa
			// kPa
			// millibar
			// mmHg
			// MPa
			'pascal' => 'Entities\Pascal',
			'Pa' => 'Entities\Pascal',
			// psi
		],
		'substance_amount' => [
			// examole
			// kilomole
			// megamole
			'mole' => 'Entities\Mole',
			// nanomole
			'particle' => 'Entities\Particle',
			// pound-mole
			// quettamole
			// zeptomole
		],
		'temperature' => [
			'celsius' => 'Entities\Celsius',
			'fahrenheit' => 'Entities\Fahrenheit',
			'kelvin' => 'Entities\Kelvin',
			'K' => 'Entities\Kelvin',
			'rankine' => 'Entities\Rankine',
		],
		'time' => [
			// century
			// day
			// hour
			// millenia
			// minute
			// month
			'planck_time' => 'Entities\PlanckTime',
			// quarta
			'second' => 'Entities\Second',
			// tertia
			'year' => 'Entities\Year',
			// week
		],
	];

	public static function get(string $path): \ReflectionClass {
		list($cat, $unit) = explode('.', $path);
		if (isset(self::list[$cat][$unit])) {
			$classname = __NAMESPACE__.'\\'.self::list[$cat][$unit];
			$reflection = new \ReflectionClass($classname);
			// $interface = __NAMESPACE__.'\\Entities\\'.self::camelCase($cat);
			$interface = __NAMESPACE__.'\\Entities\\'.Utils::camelCase($cat);
			if (!$reflection->implementsInterface($interface)) {
				throw new \Error("$classname must be implementing $interface to fit category");
			}
			return $reflection;
		}
		throw new \Error('Invalid path '.$path);
	}

	/*public static function camelCase($s) {
		$arr = explode('_', $s);
		array_walk($arr, function(&$el) {$el = ucfirst($el);});
		$s = join('', $arr);
		return $s;
	}*/

	public static function find($u, $c=null) {
		if (empty($c)) {
			foreach (self::list as $k=>$arr) {
				$found = self::find($u, $k);
				if ($found) return $found;
			}
		} else {
			if (isset(self::list[$c])) {
				$found = array_search('Entities\\'.$u, self::list[$c]);
				if ($found!==false) {
					return $c.'.'.$found;
				}
			}
		}
		return null;
	}
}
?>