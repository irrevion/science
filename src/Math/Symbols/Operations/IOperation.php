<?php
namespace irrevion\science\Math\Symbols\Operations;

interface IOperation {
	public function __toString(): string;
	public function over($symbols);
	// public function with($symbols);
	// public function assign($params);
	// public function perform();
}

?>