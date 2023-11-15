<?php

spl_autoload_register(function($class) {
	if (DIRECTORY_SEPARATOR!="\\") {
		$class = join(DIRECTORY_SEPARATOR, explode("\\", $class));
	}

	// strip 2 levels from path (vendor_name/library_name)
	$vendor_path = join(DIRECTORY_SEPARATOR, array_slice(explode(DIRECTORY_SEPARATOR, __DIR__), 0, -2));

	$class = $vendor_path.DIRECTORY_SEPARATOR.$class.'.php';
	if (file_exists($class)) {
		require $class;
	}
});

?>