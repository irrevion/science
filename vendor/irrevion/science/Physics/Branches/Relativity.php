<?php
namespace irrevion\science\Physics\Branches;

use irrevion\science\Math\Math;
use irrevion\science\Physics\Physics;

class Relativity extends Physics {
	public static function getLorentzFactor($v) {
		// https://en.wikipedia.org/wiki/Lorentz_factor
		// The Lorentz factor or Lorentz term is a quantity that expresses how much the measurements of time, length, and other physical properties change for an object while that object is moving.
		// γ = 1 / (1 - v**2 / c**2)
		$γ = 1 / Math::sqrt(1 - (($v**2) / (Physics::c**2)));
		return $γ;
	}
}
?>