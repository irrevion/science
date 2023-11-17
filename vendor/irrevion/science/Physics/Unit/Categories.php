<?php
namespace irrevion\science\Physics\Unit;

class Categories {
	const list = [
		'length' => [
			'light_year' => 'Entities\LightYear',
			'metre' => 'Entities\Metre',
		],
		'mass' => [
			'kilogram' => 'Entities\Kilogram',
		],
		'time' => [
			'second' => 'Entities\Second',
		],
	];

	public static function get(string $path): \ReflectionClass {
		list($cat, $unit) = explode('.', $path);
		if (isset(self::list[$cat][$unit])) {
			// return self::list[$cat][$unit];
			$classname = __NAMESPACE__.DIRECTORY_SEPARATOR.self::list[$cat][$unit];
			$reflection = new \ReflectionClass($classname);
			$interface = __NAMESPACE__.DIRECTORY_SEPARATOR.'Entities\\'.ucfirst($cat);
			if (!$reflection->implementsInterface($interface)) {
				throw new \Error("$classname must be implementing $interface to fit category");
			}
			// return new $classname();
			return $reflection;
		}
		throw new \Error('Invalid path '.$path);
	}
}
?>