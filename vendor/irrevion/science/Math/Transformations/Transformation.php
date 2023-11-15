<?php
namespace irrevion\science\Math\Transformations;

interface Transformation {
	public function __toString();
	public function apply($to_entity);
}

?>