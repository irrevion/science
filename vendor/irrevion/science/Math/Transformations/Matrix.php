<?php
namespace irrevion\science\Math\Transformations;

use irrevion\science\Math\Math;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\{Vector, Scalar};

class Matrix implements Transformation {
	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';
	private const T_VECTOR = 'irrevion\science\Math\Entities\Vector';

	public $structure;
	public $rows;
	public $cols;
	public $inner_type;

	public function __construct(?array $struct=null, $type=self::T_SCALAR) {
		if (!empty($struct)) {
			$this->structure = $struct;
			if ($type) {$this->structure = $this->as($type);}
			$this->updateMeta();
		}
	}

	public function as($type) {
		$M_arr = $this->structure;
		foreach ($M_arr as $n=>$col) {
			array_walk($M_arr[$n], function(&$v) use ($type) {$v = Delegator::wrap($v, $type);});
		}
		return $M_arr;
	}

	public function print($arr) {
		if (is_iterable($arr)) {
			$str = "";
			foreach ($arr as $v) {
				$str.=(strlen($str)? ', ': '').$this->print($v);
			}
			return "[$str]";
		}
		return "$arr";
	}

	public function __toString() {
		return "[ Matrix {$this->rows}x{$this->cols}: ".$this->print($this->structure)." ]";
	}

	public function applyTo($V) {
		$new_projections = [];
		$transformedV = new Vector([], $V->inner_type);
		foreach ($V as $axis=>$projection) {
			/*foreach ($this->structure[$axis] as $new_axis=>$new_axis_unitV) {
				print "new axis $new_axis unit $new_axis_unitV \n";
				$new_projections[$axis] = $new_axis_unitV->multiply($projection);
			}*/
			$new_axis_unitV = new Vector($this->structure[$axis], $this->inner_type);
			$new_projections[$axis] = $new_axis_unitV->multiply($projection);
			// print "new axis {$new_projections[$axis]} unit {$new_axis_unitV}->multiply({$projection}); \n";
		}
		// print "new_projections: ".$this->print($new_projections)."\n";
		foreach ($new_projections as $p) {
			$transformedV = $transformedV->add($p);
		}
		return $transformedV;
	}

	public function composeWith(Matrix $M): Matrix {
		throw new \Error('Not implemented yet');
	}

	public function updateMeta() {
		$this->cols = count($this->structure);
		if ($this->cols) {
			$m = 0;
			$t = 'mixed';
			foreach ($this->structure as $n=>$col) {
				if ($n==0) {
					$m = count($col);
					if ($m) {
						$t = Delegator::getType($col[0]);
					} else {
						throw new \Error('Matrix cannot contain empty columns');
					}
				} else {
					if ($m!=count($col)) {
						throw new \Error('Columns height must be equal');
					}
				}
			}
			$this->rows = $m;
			$this->inner_type = $t;
		}
	}

	/* public function createFrom($struct) { // create new instance
		throw new \Error('Not implemented yet');
	} */
}
?>