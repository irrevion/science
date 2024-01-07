<?php
namespace irrevion\science\Helpers;

use irrevion\science\Helpers\Utils;

class M extends \SplFixedArray {

	public function __construct(int $cols=0, $rows=0) {
		parent::__construct($cols);
		//$this->fill(new R($rows));
		$this->mapColumns(fn() => new R($rows));
	}

	public function __toString() {
		return Utils::printR($this);
	}

	public function col($j) {
		return clone $this[$j];
	}

	public function fill($value) {
		$n = $this->count();
		$i = 0;
		while ($i<$n) {
			$this[$i] = $value;
			$i++;
		}
		return $this;
	}

	public function isFirst(int $i): bool {
		return ($i===0);
	}

	public function isLast(int $i): bool {
		return ($this->count()===($i+1));
	}

	public function map(callable $fn): M {
		foreach ($this as $n=>$col) {
			foreach ($col as $m=>$el) {
				$this[$n][$m] = $fn($el, $n, $m);
			}
		}
		return $this;
	}

	public function mapColumns(callable $fn) {
		foreach ($this as $i=>$v) {
			//$this->offsetSet($i, $fn($v, $i));
			$this[$i] = $fn($v, $i);
		}
		return $this;
	}

	public function mapRow(int $m, callable $fn): M {
		foreach ($this as $n=>$col) {
			//$v = $col[$m]*1;
			$this[$n][$m] = $fn($this[$n][$m], $n, $m);
			//print "apply fn to col $n row $m ({$v} => {$this[$n][$m]}) \n";
		}
		return $this;
	}

	public function row($i) {
		return (new R($this->count()))->map(fn($val, $col) => $this[$col][$i]);
	}

	public function swapRows(int $i1, int $i2): M {
		$r1 = $this->row($i1);
		$r2 = $this->row($i2);
		$this->mapRow($i1, fn($val, $col) => $r2[$col]);
		$this->mapRow($i2, fn($val, $col) => $r1[$col]);
		return $this;
	}
}
?>