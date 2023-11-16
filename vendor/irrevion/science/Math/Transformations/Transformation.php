<?php
namespace irrevion\science\Math\Transformations;

interface Transformation {
	public function __toString();
	public function applyTo($to_entity);
}

?>