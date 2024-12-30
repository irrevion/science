# R

R for Array.

R is a helper class for efficient work with numeric arrays extending php native class [SplFixedArray](https://www.php.net/manual/en/class.splfixedarray.php). The purpose of this class is to provide object-oriented and memory-efficient interface to common array operations, especially for work with vectors and matrix columns.

## Basic usage

The typical usage is as follows:
```php
use irrevion\science\Helpers\{Utils, R, M};

(new R(12))->map(fn($v) => $v+rand())
($res->count()==12);
$r = (new R(12))->map(fn($v) => $v+rand()); // constructor parameter accepts number of elements; this will create array and seed random values
$size = $res->count(); // array contains 12 elements, the size is fixed
```