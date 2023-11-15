<?php
namespace irrevion\science\Math\Transformations;

use irrevion\science\Math\Math;

class Matrix implements Transformation {
	public $this->structure;
	public $this->rows;
	public $this->cols;

	public function __construct(?array $struct=null) {
		if (!empty($struct)) {
			$this->structure = $struct;
			$this->updateMeta();
		}
	}

	public function __toString() {
		return "[ Matrix {$this->rows}x{$this->cols}: ".var_export($this->structure, 1)." ]";
	}

	public function apply($to) {
		throw new \Error('Not implemented yet');
	}

	public function createFrom($struct) { // create new instance
		throw new \Error('Not implemented yet');
	}
}
?>