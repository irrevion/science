<?php
namespace irrevion\science\Math\Entities;

interface Entity {
	public function __toString();
	public function add($value);
	public function subtract($value);
	public function multiply($value);
	public function divide($value);
}

?>