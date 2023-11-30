<?php
namespace irrevion\science\Physics\Unit;

class Categories {
	const list = [
		'angle' => [
			'degree' => 'Entities\Degree',
			// gon
			// mil
			'radian' => 'Entities\Radian',
			// turn
		],
		'brightness' => [
			// apostilb
			// bril
			'candela_per_square_metre' => 'Entities\Nit',
			// foot_lambert
			'nit' => 'Entities\Nit',
			// lambert
			// skot
			'stilb' => 'Entities\Stilb',
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
		'energy' => [
			// btu
			// calorie
			// coal_ton
			'electron_volt' => 'Entities\ElectronVolt',
			'eV' => 'Entities\ElectronVolt',
			// erg
			// exajoule
			// foot_poundal
			// gigajoule
			'hartree' => 'Entities\HartreeEnergy',
			'joule' => 'Entities\Joule',
			// kilocalorie
			// kcal
			// kilojoule
			// kilowatt_hour
			// kWh
			// mbtu
			// plank
			// quad
			// rydberg
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
			// 'kilohertz' => 'Entities\KiloHertz',
			// 'kHz' => 'Entities\KiloHertz',
			// megahertz
			// 'rpm' => 'Entities\RevolutionPerMinute',
			// terahertz
		],
		'length' => [
			// Angstrom
			'astronomical_unit' => 'Entities\AstronomicalUnit',
			'au' => 'Entities\AstronomicalUnit',
			// bohr_radius
			// centimetre
			// feet
			// inch
			// 'kilometre'
			// 'km'
			'light_year' => 'Entities\LightYear',
			'ly' => 'Entities\LightYear',
			'metre' => 'Entities\Metre',
			// mikron
			// mile
			// nautical_mile
			'parsec' => 'Entities\Parsec',
			'planck_length' => 'Entities\PlanckLength',
			// sm
			// yard
		],
		'luminous_intensity' => [
			'candela' => 'Entities\Candela',
		],
		'mass' => [
			// carat
			// dalton
			// earth
			'electron_mass' => 'Entities\ElectronMass',
			// gram
			'kilogram' => 'Entities\Kilogram',
			'kg' => 'Entities\Kilogram',
			// moon
			// ounce
			'pound' => 'Entities\Pound',
			// slug
			'solar_mass' => 'Entities\SolarMass',
		],
		'substance_amount' => [
			'mole' => 'Entities\Mole',
		],
		'temperature' => [
			'celsius' => 'Entities\Celsius',
			'fahrenheit' => 'Entities\Fahrenheit',
			'kelvin' => 'Entities\Kelvin',
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
			$classname = __NAMESPACE__.DIRECTORY_SEPARATOR.self::list[$cat][$unit];
			$reflection = new \ReflectionClass($classname);
			$interface = __NAMESPACE__.DIRECTORY_SEPARATOR.'Entities\\'.self::camelCase($cat);
			if (!$reflection->implementsInterface($interface)) {
				throw new \Error("$classname must be implementing $interface to fit category");
			}
			return $reflection;
		}
		throw new \Error('Invalid path '.$path);
	}

	public static function camelCase($s) {
		$arr = explode('_', $s);
		array_walk($arr, function(&$el) {$el = ucfirst($el);});
		$s = join('', $arr);
		return $s;
	}

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