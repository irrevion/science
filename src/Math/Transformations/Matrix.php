<?php
namespace irrevion\science\Math\Transformations;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Utils;
use irrevion\science\Math\Operations\Delegator;
use irrevion\science\Math\Entities\{Vector, Scalar};

class Matrix implements Transformation, \ArrayAccess {
	private const T_SCALAR = 'irrevion\science\Math\Entities\Scalar';
	private const T_VECTOR = 'irrevion\science\Math\Entities\Vector';

	public $structure;
	public $rows;
	public $cols;
	public $inner_type;

	public function __construct(?array $struct=null, ?string $type=self::T_SCALAR) {
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

	// Calculate Determinant using native types.
	// The same as det() except does not converts values toNumber()
	public function determinant() {
		if ($this->rows!=$this->cols) {
			throw new \Error("Determinant can be calculated only for square matrices, {$this->rows} x {$this->cols} given.");
		}

		if ($this->rows==1) {
			return $this->structure[0][0];
		}

		if ($this->rows==2) {
			return $this->structure[0][0]->multiply($this->structure[1][1])->subtract($this->structure[0][1]->multiply($this->structure[1][0]));
		}

		$k = 1;
		$D = Delegator::wrap(0, $this->inner_type);
		while ($k<=$this->cols) {
			$M_det = $this->structure;
			array_splice($M_det, ($k-1), 1);
			$M_det = array_map(function($col) {return array_slice($col, 1);}, $M_det);
			$D = $D->{(($k%2)? 'add': 'subtract')}($this->structure[$k-1][0]->multiply((new self($M_det, $this->inner_type))->determinant()));
			$k++;
		}
		return $D;
	}

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
		}
		foreach ($new_projections as $p) {
			$transformedV = $transformedV->add($p);
		}
		return $transformedV->pad($this->cols);
	}

	public function composeWith(Matrix $M): Matrix {
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

	public function multiply($y) {
		// as matrix is not value entity there is no such thing as matrix multiplication
		// however, traditions shall be obeyed
		$t = Delegator::getType($y);
		if ($t==self::class) {
			return $this->composeWith($y);
		} else if ($t==self::T_VECTOR) {
			return $this->applyTo($y);
		} else if ($t==self::T_SCALAR) {
			return $this->multiplyScalar($y);
		}
		throw new \Error('Unknown argument type '+$t);
	}

	public function multiplyScalar($y): self {
		return $this->map(fn($v) => $v->multiply($y));
	}

	public function divideScalar($y): self {
		return $this->map(fn($v) => $v->divide($y));
	}

	public function transpose(): self {
		return new self(Utils::arrayColumnsToAttributes($this->structure), $this->inner_type);
	}

	public function minor($col_index, $row_index) {
		if ($this->rows!=$this->cols) {
			throw new \Error("Minor can be defined only for square matrices, {$this->rows} x {$this->cols} given");
		}
		if (($col_index>=$this->cols) || ($row_index>=$this->rows)) {
			throw new \Error("Element index ( column $col_index, row $row_index ) out of bound {$this->rows} x {$this->cols}");
		}
		if (($this->cols<2) || ($this->rows<2)) {
			throw new \Error("Cannot get minor of such a small matrix");
		}

		$M = $this->structure;
		array_splice($M, $col_index, 1); // remove column
		foreach ($M as $curr_col_index=>$col) {
			unset($col[$row_index]); // remove elements at row index
			$col = array_values($col); // reorder indexes
			$M[$curr_col_index] = $col;
		}

		return new self($M, $this->inner_type);
	}

	public function cofactorMatrix() {
		// indexes in formulas starts with 1, in arrays from 0, but since all we need is negate determinant when i is even and j is odd or j is even and i is odd, there is no difference of the starting value
		// when both indexes is 0 negator is -1**0 = 1, and when both indexes is 1 negator is -1**2 = 1 too
		// that means we can use $col_index+$row_index directly instead of ($col_index+1)+($row_index+1)
		//return $this->map(fn($el, $col_index, $row_index) => $this->minor($col_index, $row_index)->determinant()->multiply(-1**($col_index+$row_index)), $this->inner_type);
		return $this->map(function($el, $col_index, $row_index) {
			// print "$el at ($col_index, $row_index): D is ".$this->minor($col_index, $row_index)->determinant().", negator is ".((-1)**($col_index+$row_index))." \n";
			return $this->minor($col_index, $row_index)->determinant()->multiply((-1)**($col_index+$row_index));
		}, $this->inner_type);
	}

	public function adjugate() {
		if ($this->rows!=$this->cols) {
			throw new \Error("Matrix is not square; cannot get adjugate Matrix of a {$this->rows} x {$this->cols} matrix");
		}
		// A**-1 = M_adj(A) / Det(A)
		// So in case 1x1 martix Det(A) = a(1, 1) => A**-1 = 1/a(1, 1) = M(1) / Det(A)
		if ($this->cols===1) {return new self([[1]]);}
		// M_adj(A) = M_tr( M_cf( A ))
		return $this->cofactorMatrix()->transpose();
	}

	public function reverseTransformation() {
		// https://www.toppr.com/guides/maths/determinants/adjoint-and-inverse-of-a-matrix/
		// https://byjus.com/maths/determinants-and-matrices/#inverse-matrix
		// https://en.wikipedia.org/wiki/Adjugate_matrix
		// https://mathworld.wolfram.com/MatrixInverse.html

		if ($this->rows!=$this->cols) {
			throw new \Error("Matrix is not square; cannot get determinant of a {$this->rows} x {$this->cols} matrix");
		}
		$D = $this->determinant();
		if ($D===0) {
			throw new \Error("Determinant is 0; cannot get reverse transformation of a singular matrix");
		}
		return $this->adjugate()->divideScalar($D);
	}

	public function map(callable $f, string $t=self::T_SCALAR): self {
		$M = $this->structure;
		$Mr = [];
		foreach ($M as $n=>$col) {
			foreach ($col as $m=>$el) {
				$Mr[$n][$m] = $f($el, $n, $m);
			}
		}
		return new self($Mr, $t);
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

	// methods to comply interface \ArrayAccess

	public function offsetExists($offset): bool {
		return isset($this->structure[$offset]);
	}

	public function offsetGet($offset): mixed {
		return (isset($this->structure[$offset])? $this->structure[$offset]: null);
	}

	public function offsetSet($offset, $value): void {
		throw new \Error('Cannot directly overwrite whole column');
	}

	public function offsetUnset($offset): void {
		// throw new \Error('Immutable object');
		unset($this->structure[$offset]);
		$this->structure = array_values($this->structure);
		$this->updateMeta();
	}
}
?>