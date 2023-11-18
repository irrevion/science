<?php
namespace irrevion\science\Physics\Unit;

class Categories {
	const list = [
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
			$interface = __NAMESPACE__.DIRECTORY_SEPARATOR.'Entities\\'.ucfirst($cat);
			if (!$reflection->implementsInterface($interface)) {
				throw new \Error("$classname must be implementing $interface to fit category");
			}
			return $reflection;
		}
		throw new \Error('Invalid path '.$path);
	}
}
?>