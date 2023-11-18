<?php
namespace irrevion\science\Physics\Unit;

class Categories {
	const list = [
		'electric_current' => [
			'abampere' => 'Entities\AbAmpere',
			'ampere' => 'Entities\Ampere',
			'statampere' => 'Entities\StatAmpere',
		],
		'length' => [
			'light_year' => 'Entities\LightYear',
			'metre' => 'Entities\Metre',
			'parsec' => 'Entities\Parsec',
		],
		'mass' => [
			'kilogram' => 'Entities\Kilogram',
			'pound' => 'Entities\Pound',
		],
		'time' => [
			'second' => 'Entities\Second',
			'year' => 'Entities\Year',
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