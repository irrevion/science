# NaN

The default PHP NaN value is type of float. PHP provides built-in function [is_nan()](https://www.php.net/manual/en/function.is-nan.php) to distinquish this float number apart of valid number.

All functions that should return Entity object (implementing Entity interface) in case when NaN value emerges in calculation wraps it using NaN class:
```php
<?php
namespace irrevion\science\Math\Entities;

class NaN implements Entity {
	public $value = null;
	public function __construct() {}
	public function __toString() {return "NaN";}
	public function toNumber() {return sqrt(-1);}
	public function add($n) {return $this;}
	public function subtract($n) {return $this;}
	public function multiply($n) {return $this;}
	public function divide($n) {return $this;}
	public function isNaN() {return true;}
}
?>
```
So you can avoid getting result as non-Entity number type.

Once imported
```php
use irrevion\science\Math\Entities\{NaN, Scalar};
```
you can use it to return invalid number as object:
```php
return new NaN;
```