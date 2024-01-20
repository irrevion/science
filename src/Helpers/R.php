<?php
namespace irrevion\science\Helpers;

use irrevion\science\Helpers\Utils;

class R extends \SplFixedArray {

	public $length = 0;

	public function __construct(int $size=0) {
		parent::__construct($size);
		$this->fill();
		$this->length = $size;
	}

	public function __toString(): string {
		return Utils::printR($this);
	}

	public function any(callable $fn): bool {
		// check if at least one element satisfies condition
		foreach ($this as $i=>$v) {
			$pass = !!$fn($v, $i);
			if ($pass) return true;
		}
		return false;
	}

	public function at(int $i) {
		if ($i<0) $i = ($this->length + $i);
		if ($i>=$this->length) return null;
		if (isset($this[$i])) return $this[$i];
		return null;
	}

	public function every(callable $fn): bool {
		// check all elements against condition callback
		foreach ($this as $i=>$v) {
			$pass = !!$fn($v, $i);
			if (!$pass) return false;
		}
		return true;
	}

	public function fill(int|float $value=0.0): R {
		$n = $this->count();
		$i = 0;
		while ($i<$n) {
			$this[$i] = $value;
			$i++;
		}
		return $this;
	}

	public function filter(callable $fn): R {
		$r = new self(0);
		foreach ($this as $i=>$v) {
			$pass = !!$fn($v, $i);
			if ($pass) $r = $r->push($v);
		}
		return $r;
	}

	public function find(callable $fn, int $start_from=0): ?int {
		if ($start_from<0) $start_from = ($this->length + $start_from);
		foreach ($this as $i=>$v) {
			if ($i<$start_from) continue;
			if ($fn($v, $i)) return $i;
		}
		return null;
	}

	public function first() {return $this[0];}

	#[\ReturnTypeWillChange]
	#[\Override]
	public static function fromArray(array $arr, bool $damnBarbaraLiskov=true): R {
		// remember, Barbara, inheritance is not enough for evolution
		// there is no evolution without mutations
		// you cannot treat fungus and cheetah same way because they have same ancestor
		$r = new self(0);
		foreach ($arr as $i=>$v) {
			$r = $r->push($v);
		}
		return $r;
	}

	public function includes($val, int $start_from=0) {
		$i = $this->find(fn($v, $i) => $v===$val, $start_from);
		return !is_null($i);
	}

	public function indexOf($val): int {
		return $this->find(fn($v) => ($v===$val));
	}

	public function indexOfMax() {
		$max = null;
		$max_i = null;
		foreach ($this as $i=>$v) {
			if (is_null($max) || ($v>$max)) {
				$max = $v;
				$max_i = $i;
			}
		}
		return $max_i;
	}

	public function indexOfMin() {
		$max = null;
		$max_i = null;
		foreach ($this as $i=>$v) {
			if (is_null($max) || ($v>$max)) {
				$max = $v;
				$max_i = $i;
			}
		}
		return $max_i;
	}

	public function isEqual(R $r): bool {
		if ($this->length!=$r->length) return false;
		if ($this->any(fn($v, $i) => (!isset($r[$i]) || ($r[$i]!=$v)))) return false;
		return true;
	}

	public function isFirst(int $i): bool {
		return ($i===0);
	}

	public function isLast(int $i): bool {
		return ($this->count()===($i+1));
	}

	public function last() {return $this[$this->length - 1];}

	public function lastIndex() {return ($this->length - 1);}

	public function map(callable $fn) {
		foreach ($this as $i=>$v) {
			$this->offsetSet($i, $fn($v, $i));
			//$this[$i] = $fn($v, $i);
		}
		return $this;
	}

	public function max() {
		$max = null;
		foreach ($this as $i=>$v) {
			if (is_null($max) || ($v>$max)) {$max = $v;}
		}
		return $max;
	}

	public function merge(iterable $r2): R {
		$r = new self(0);
		foreach ($this as $i=>$v) {
			$r = $r->push($v);
		}
		foreach ($r2 as $i=>$v) {
			$r = $r->push($v);
		}
		return $r;
	}

	public function min() {
		$min = null;
		foreach ($this as $i=>$v) {
			if (is_null($min) || ($v<$min)) {$min = $v;}
		}
		return $min;
	}

	public function pop(): R {
		$r = clone $this;
		$at = $this->length--;
		$r->offsetUnset($at);
		$r->length = $at;
		$r->setSize($r->length);
		return $r;
	}

	public function push(mixed $val): R {
		$r = clone $this; // its fixed, bro, dont u think changing array size should not affect original one?
		$at = $r->length;
		$r->length++;
		$r->setSize($r->length);
		$r[$at] = $val;
		return $r;
	}

	public function reduce(callable $fn, mixed $init_val=0) {
		$res = $init_val;
		foreach ($this as $i=>$v) {
			$res = $fn($res, $v, $i);
		}
		return $res;
	}

	public function reverse(): R {
		for ($i=0; $i<Math::floor(($this->length / 2) - 2); $i++) {
			list($this[$i], $this[$this->length - $i]) = [$this[$this->length - $i], $this[$i]];
		}
		return $this;
	}

	public function slice(int $from=0, ?int $length=null): R {
		if ($from<0) $from = ($this->length + $from);
		if (($from>=$this->length) || ($length<0)) return new self(0);
		if (is_null($length) || (($length+$from)>$this->length)) $length = ($this->length - $from);
		$stop_at = ($length+$from);
		$r = new self(0);
		for ($i=$from; $i<$stop_at; $i++) {
			$r = $r->push($this[$i]);
		}
		return $r;
	}

	public function shift(int $n=1): R {
		$r = new self(0);
		if (($n<1) || ($n>=$this->length)) return $r;
		for ($i=$n; $i<$this->length; $i++) {
			$r = $r->push($this[$i]);
		}
		return $r;
	}

	public function splice(int $from=0, ?int $del_count=null, ?iterable $ins=null): R {
		if ($from<0) $from = ($this->length + $from);
		if (($from>=$this->length) || ($del_count<=0)) return (is_null($ins)? clone $this: $this->merge($ins));
		$r = new self(0);
		for ($i=0; $i<$this->length; $i++) {
			if ($i===$from) {
				if (!is_null($ins)) $r = $r->merge($ins);
				$i+=$del_count;
			}
			$r = $r->push($this[$i]);
		}
		return $r;
	}

	public function swap(int $index1, int $index2): R {
		[$this[$index2], $this[$index1]] = [$this[$index1], $this[$index2]];
		return $this;
	}

	public function unshift(mixed $val): R {
		$r = new self(0);
		$r = $r->push($val);
		foreach ($this as $i=>$v) {
			$r = $r->push($v);
		}
		return $r;
	}
}
?>