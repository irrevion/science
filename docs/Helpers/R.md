# R

R for Array.

R is a helper class for efficient work with numeric arrays extending php native class [SplFixedArray](https://www.php.net/manual/en/class.splfixedarray.php). The purpose of this class is to provide object-oriented and memory-efficient interface to common array operations, especially for work with vectors and matrix columns. Matrices eats lots of RAM, you know.
It is recommended to store only integer or float values in R-type array.

## Basic usage

The typical usage is as follows:
```php
use irrevion\science\Helpers\{Utils, R, M};

$r = (new R(12))->map(fn($v) => $v+rand()); // constructor parameter accepts number of elements; this will create array and seed random values
$size = $res->count(); // array contains 12 elements, the size is fixed
```

## Class synopsis

```php
class R extends \SplFixedArray {
	public function __construct(int $size=0) {}
	public function __toString(): string {} // prints array

	/* inherited or overloaded finctions */
	public function __serialize(): array {} // inherited https://www.php.net/manual/en/splfixedarray.serialize.php
	public function __unserialize(array $data): void {} // inherited https://www.php.net/manual/en/splfixedarray.unserialize.php
	#[\Deprecated]
	public function __wakeup(): void {} // inherited https://php.net/manual/en/splfixedarray.wakeup.php
	// public static fromArray(array $array, bool $preserveKeys = true): SplFixedArray {} // overloaded https://www.php.net/manual/en/splfixedarray.fromarray.php
	#[\ReturnTypeWillChange]
	public static function fromArray(array $arr, bool $damnBarbaraLiskov=true): R {} // creates R type object from array and disobeys Barbara Liskov principle
	public function count(): int {} // inherited https://www.php.net/manual/en/splfixedarray.count.php
	public function current(): mixed {} // inherited https://www.php.net/manual/en/splfixedarray.current.php
	public function getIterator(): Iterator {} // inherited https://www.php.net/manual/en/splfixedarray.getiterator.php
	public function getSize(): int {} // inherited https://www.php.net/manual/en/splfixedarray.getsize.php
	public function jsonSerialize(): array {} // inherited https://www.php.net/manual/en/splfixedarray.jsonserialize.php
	public function key(): int {} // inherited https://www.php.net/manual/en/splfixedarray.key.php
	public function next(): void {} // inherited https://www.php.net/manual/en/splfixedarray.next.php
	public function offsetExists(int $index): bool {} // inherited https://www.php.net/manual/en/splfixedarray.offsetexists.php
	public function offsetGet(int $index): mixed {} // inherited https://www.php.net/manual/en/splfixedarray.offsetget.php
	public function offsetSet(int $index, mixed $value): void {} // inherited https://www.php.net/manual/en/splfixedarray.offsetset.php
	public function offsetUnset(int $index): void {} // inherited https://www.php.net/manual/en/splfixedarray.offsetunset.php
	public function rewind(): void {} // inherited https://www.php.net/manual/en/splfixedarray.rewind.php
	public function setSize(int $size): true {} // inherited https://www.php.net/manual/en/splfixedarray.setsize.php
	public function toArray(): array {} // inherited https://www.php.net/manual/en/splfixedarray.toarray.php
	public function valid(): bool {} // inherited https://www.php.net/manual/en/splfixedarray.valid.php

	/* additional methods */
	public function any(callable $fn): bool {} // check if at least one element satisfies condition
	public function at(int $i) {} // get element value at given position
	public function every(callable $fn): bool {} // check all elements against condition callback
	public function fill(int|float $value=0.0): R {} // fills array with given value
	public function filter(callable $fn): R {} // returns new R instanse with values filtered by given callback function
	public function find(callable $fn, int $start_from=0): ?int {} // get index of first element to satisfy callback function check
	public function first() {} // get first element value
	public function includes($val, int $start_from=0): bool {} // checks if element is in array
	public function indexOf($val): int {} // returns first index of given value
	public function indexOfMax() {} // get index of element having greatest value
	public function indexOfMin() {} // get index of element having lowest value
	public function isEqual(R $r): bool {} // compare with another R type array
	public function isFirst(int $i): bool {} // returns true for 0 index
	public function isLast(int $i): bool {} // returns true for last index
	public function last() {} // returns last value
	public function lastIndex() {} // get last index of array
	public function map(callable $fn) {} // apply callback function to every R-array value
	public function max() {} // get max value
	public function merge(iterable $r2): R {} // merge this with another array-like variable
	public function min() {} // get min value
	public function pop(): R {} // return new R-array without last element
	public function push(mixed $val): R {} // return new R instance with new element added to the end
	public function reduce(callable $fn, mixed $init_val=0) {} // apply callback and accumulate result
	public function reverse(): R {} // reverse elements order
	public function slice(int $from=0, ?int $length=null): R {} // get chunk of array
	public function shift(int $n=1): R {} // skip n elements from beginning
	public function splice(int $from=0, ?int $del_count=null, ?iterable $ins=null): R {} // delete or replace part of the R
	public function sum(): int|float {} // calculate sum of all elements
	public function swap(int $index1, int $index2): R {} // swap value of elements by given indices
	public function unshift(mixed $val): R {} // add element to the beginning of new R
}
```