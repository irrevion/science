<?php
namespace irrevion\science\Math\Symbols;

interface ISymbol {
	public function __toString(): string;
	public function assign($value);
}

?>