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

	public function det() {
		// https://en.wikipedia.org/wiki/Determinant
		// https://mathworld.wolfram.com/Determinant.html

		if ($this->rows!=$this->cols) {
			throw new \Error("Determinant can be calculated only for square matrices, {$this->rows} x {$this->cols} given.");
		}

		if ($this->rows==1) {
			// matix of 1 element has scaling factor equal to its sole scalar element
			return $this->structure[0][0]->toNumber();
		}

		if ($this->rows==2) {
			// no need to spin the loops for 2D matrix determinant, it has simple geometric representation
			// https://www.youtube.com/watch?v=fvQ013dZb9c&t=80s
			// ΔM₂² = ad - bc

			// M₂² = [
			// 	[a, b],
			// 	[c, d]
			// ];
			$determinant_calculated = $this->structure[0][0]->multiply($this->structure[1][1])->subtract($this->structure[0][1]->multiply($this->structure[1][0]));
			// this is equal to square of paralleloqram formed by two vectors [a, b] and [c, d]
			// and has the meaning of how much matrix transformed the plane containing those vectors
			// assuming that before transformation they was [1, 0] and [0, 1] (basis vectors)
			return $determinant_calculated->toNumber();
		}

		// https://www.hse.ru/data/2010/10/25/1222762965/%D0%9B%D0%95%D0%9A%D0%A6%D0%98%D0%AF%2003_%D0%9B.%D0%90..pdf
		// Formulae 3.1
		$k = 1; // from 1st column to n
		$determinant_calculated = 0;
		while ($k<=$this->cols) {
			// yo, dj, spin dat shit
			$M_det = $this->structure;
			array_splice($M_det, ($k-1), 1); // remove column
			$M_det = array_map(function($col) {return array_slice($col, 1);}, $M_det); // remove row
			$determinant_calculated+=(($k%2)? 1: -1) * $this->structure[$k-1][0]->toNumber() * (new self($M_det))->det();
			// multiply current column 0-element to determinant (n-1)

			$k++;
		}
		return $determinant_calculated;
		// thats it, folks
	}
	public function determinant(...$args) {return $this->det(...$args);}

	public function applyTo($V) {
		if (Delegator::getType($V)!=self::T_VECTOR) {
			throw new \Error('Invalid type (vector expected)');
		}
		if ($this->cols!=$V->length) {
			throw new \Error('Matrix columns number should be equal with vector components number');
		}
		$new_projections = [];
		$transformedV = new Vector([], $V->inner_type);
		foreach ($V as $axis=>$projection) {
			$new_axis_unitV = new Vector($this->structure[$axis], $this->inner_type);
			$new_projections[$axis] = $new_axis_unitV->multiply($projection);
			// print "new axis {$new_projections[$axis]} unit {$new_axis_unitV}->multiply({$projection}); \n";
		}
		// print "new_projections: ".$this->print($new_projections)."\n";
		foreach ($new_projections as $p) {
			$transformedV = $transformedV->add($p);
		}
		return $transformedV->pad($this->cols);
	}

	public function composeWith(Matrix $M): Matrix {
		//throw new \Error('Not implemented yet');
		if ($this->cols!=$M->rows) {
			throw new \Error('Primary matrix columns number should be equal to secondary matrix rows number');
		}
		$composedM = [];
		foreach ($this->structure as $n=>$vector) {
			$vector = new Vector($vector, $this->inner_type);
			$vector = $M->applyTo($vector);
			$composedM[] = $vector->toArray();
		}
		$composedM = new self($composedM, $this->inner_type);
		return $composedM;
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
						throw new \Error('Columns height must be equal ('.$m.'!='.count($col).')');
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