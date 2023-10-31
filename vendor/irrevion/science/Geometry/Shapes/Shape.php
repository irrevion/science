<?php
namespace irrevion\science\Geometry\Shapes;

interface Entity {
	public function __toString();
	public function translate($vector);
	public function rotate($angle, $center=null);
	public function reflect($axis);
	public function project($surface);
	public function getDimensionsNumber();
	// also recommended to implement whenever possible
	// public function getDistanceTo(); // get shortest distance between two same-dimensional shapes
	// public function intersectsWith(); // true if distance to another same-dimensional shape less or equal 0
	// public function getSize(); // scalar to compare same-dimensional shapes
}

?>