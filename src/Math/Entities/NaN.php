<?php
namespace irrevion\science\Math\Entities;

class NaN implements Entity {
	public $value = null;
	public function __construct() {}
	public function __toString() {return "NaN";}
	public function toNumber() {return sqrt(-1);}
	public function add($n) {return $this;}
	public function subtract($n) {return $this;}
	public function multiply($n) {return $this;}
	public function divide($n) {return $this;}
	public function isNaN() {return true;}
}
?>