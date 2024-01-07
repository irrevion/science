<?php
namespace irrevion\science\Helpers;

use irrevion\science\Helpers\Utils;

class R extends \SplFixedArray {

	public function __construct(int $size=0) {
		parent::__construct($size);
		$this->fill();
	}

	public function __toString() {
		return Utils::printR($this);
	}

	public function fill(int|float $value=0.0) {
		$n = $this->count();
		$i = 0;
		while ($i<$n) {
			$this[$i] = $value;
			$i++;
		}
		return $this;
	}

	public function find(callable $fn, int $start_from=0) {
		foreach ($this as $i=>$v) {
			if ($i<$start_from) continue;
			if ($fn($v, $i)) return $i;
		}
		return null;
	}

	public function isLast(int $i): bool {
		return ($this->count()===($i+1));
	}

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
}
?>