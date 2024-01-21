<?php
namespace irrevion\science\Helpers;

use irrevion\science\Helpers\Utils;
use irrevion\science\Helpers\R;
use irrevion\science\Math\Math;

class M extends \SplFixedArray {

	public $length = 0;
	public $height = 0;

	public function __construct(int $cols=0, $rows=0) {
		parent::__construct($cols);
		//$this->fill(new R($rows));
		$this->mapColumns(fn() => new R($rows));
		$this->length = $cols;
		$this->height = $rows;
	}

	public function __toString(): string {
		return Utils::printR($this);
	}

	public function addRow(int $target, int $donor): M {
		return $this->mapRow($target, fn($val, $col) => $val+$this[$col][$donor]);
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

	public function col(int $j): R {
		return clone $this[$j];
	}

	public function every(callable $fn): bool {
		// check all elements against condition callback
		foreach ($this as $i=>$v) {
			$pass = !!$fn($v, $i);
			if (!$pass) return false;
		}
		return true;
	}

	public function fill($value): M {
		$n = $this->count();
		$i = 0;
		while ($i<$n) {
			$this[$i] = $value;
			$i++;
		}
		return $this;
	}

	public function filter(callable $fn): M {
		$length = 0;
		$height = 0;
		$passed = [];
		foreach ($this as $i=>$v) {
			$pass = !!$fn($v, $i);
			if ($pass) $passed[] = $v;
		}
		$length = count($passed);
		$height = (isset($passed[0])? count($passed[0]): 0);
		return (new self($length, $height))->mapColumns(fn($v, $i) => $passed[$i]);
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

	public function isEchelon() {
		$rows = $this->rows();
		$isPivot = (fn($v) => Math::compare($v, '!=', 0));
		$nextPivotOnLeft = function($r, $i) use ($rows, $isPivot) {
			// check if next pivot index is not on the right of current
			$pivot = $r->find(fn($v) => Math::compare($v, '!=', 0));
			if (is_null($pivot)) return false;
			if ($rows->isLast($i)) return false;
			$next_pivot = $rows[$i+1]->find($isPivot);
			if (is_null($next_pivot)) return false;
			return ($next_pivot<=$pivot);
		};
		if ($rows->any($nextPivotOnLeft)) return false;
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

	public function map(callable $fn): M {
		foreach ($this as $n=>$col) {
			foreach ($col as $m=>$el) {
				$this[$n][$m] = $fn($el, $n, $m);
			}
		}
		return $this;
	}

	public function mapColumns(callable $fn): M {
		foreach ($this as $i=>$v) {
			//$this->offsetSet($i, $fn($v, $i));
			$this[$i] = $fn($v, $i);
		}
		return $this;
	}

	public function mapRow(int $m, callable $fn): M {
		foreach ($this as $n=>$col) {
			$this[$n][$m] = $fn($this[$n][$m], $n, $m);
		}
		return $this;
	}

	public function mapRows(callable $fn): R {
		$M_rows = $this->rows();
		$R_res = new R(0);
		foreach ($M_rows as $i=>$v) {
			$R_res = $R_res->push($fn($v, $i));
		}
		return $R_res;
	}

	public function reduce(callable $fn, mixed $init_val=0): mixed {
		$res = $init_val;
		foreach ($this as $i=>$v) {
			$res = $fn($res, $v, $i);
		}
		return $res;
	}

	public function row(int $i): R {
		return (new R($this->count()))->map(fn($val, $col) => $this[$col][$i]);
	}

	public function rows() {
		return (new self($this->height, $this->length))->mapColumns(fn($val, $col) => $this->row($col));
	}

	public function scaleRow(int $i, float|int $k): M {
		// return $this->row($i)->map(fn($v) => $v*$k);
		return $this->mapRow($i, fn($v) => $v*$k);
	}

	public function sum(int $col_index): null|int|float {
		if (!isset($this[$col_index])) return null;
		return $this[$col_index]->reduce(fn($sum, $v) => $sum+=$v);
	}

	public function swapRows(int $i1, int $i2): M {
		$r1 = $this->row($i1);
		$r2 = $this->row($i2);
		$this->mapRow($i1, fn($val, $col) => $r2[$col]);
		$this->mapRow($i2, fn($val, $col) => $r1[$col]);
		return $this;
	}

	public function toArray(): array {
		$r = clone $this;
		return $r->mapColumns(fn($col) => $col->toArray())->reduce(function($accumulated, $curr_val, $curr_index) {
			$accumulated[$curr_index] = $curr_val;
			return $accumulated;
		}, []);
	}

	public function zerosBelow() {
		$rows = $this->rows();
		$isZeroRow = function($row) {return $row->every(fn($v) => Math::compare($v, '=', 0));};
		$first_zero_row_index = $rows->find($isZeroRow);
		if (is_null($first_zero_row_index)) return true;
		$nonZeroRows = function($row) {return $row->any(fn($v) => Math::compare($v, '!=', 0));};
		$last_non_zero_row_index = $rows->filter($nonZeroRows)->lastIndex();
		return ($first_zero_row_index>$last_non_zero_row_index);
	}
}
?>