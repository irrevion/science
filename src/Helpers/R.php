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

	public function map(callable $fn) {
		foreach ($this as $i=>$v) {
			$this->offsetSet($i, $fn($v, $i));
			//$this[$i] = $fn($v, $i);
		}
		return $this;
	}
}
?>