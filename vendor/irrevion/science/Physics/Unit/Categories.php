<?php
namespace irrevion\science\Physics\Unit;

class Categories {
	const list = [
		'electric_current' => [
			'abampere' => 'Entities\AbAmpere',
			'ampere' => 'Entities\Ampere',
			// elementary_charge_per_planck_time
			// elementary_charge_per_second
			'statampere' => 'Entities\StatAmpere',
		],
		'length' => [
			'astronomical_unit' => 'Entities\AstronomicalUnit',
			'au' => 'Entities\AstronomicalUnit',
			// bohr_radius
			// centimetre
			// feet
			// inch
			// 'kilometre'
			// 'km'
			'light_year' => 'Entities\LightYear',
			'metre' => 'Entities\Metre',
			// mikron
			// mile
			// nautical_mile
			'parsec' => 'Entities\Parsec',
			'planck_length' => 'Entities\PlanckLength',
			// sm
			// yard
		],
		'mass' => [
			// carat
			'electron_mass' => 'Entities\ElectronMass',
			// gram
			'kilogram' => 'Entities\Kilogram',
			// ounce
			'pound' => 'Entities\Pound',
			'solar_mass' => 'Entities\SolarMass',
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
			'second' => 'Entities\Second',
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
}
?>