# Physics

Physics is a static class available under namespace
```php
use irrevion\science\Physics\Physics;
```
and providing basic methods and constants. It should not contain any specialized methods to obtain practical results. All other branches of Physics ( Relativity, Astronomy, Astrophysics, QCD, QED, QFT, Ballistics, Newtonian, Hydrodynamics, Aerodynamics, Acoustics, etc. ) will extend this class and implement specialized methods.

## Constants

```php
const ALPHA = 0.0072973525693;
const α = self::ALPHA;
// https://en.wikipedia.org/wiki/Fine-structure_constant
// Fine structure constant, also known as the Sommerfeld constant, commonly denoted by α, is a fundamental physical constant which quantifies the strength of the electromagnetic interaction between elementary charged particles.

const AVOGADRO = 6.02214076e23; // particles
// https://en.wikipedia.org/wiki/Avogadro_constant
// The Avogadro constant is an SI defining constant with an exact value of 6.02214076×1023 mol-1 (unit of reciprocal moles). It is used as a normalization factor in the amount of substance in a sample (in SI units of moles), defined as the number of constituent particles (usually molecules, atoms, or ions) divided by A.

const BOHR_MAGNETON = 9.2740100783E-24; // J/T
const μB = self::BOHR_MAGNETON;
// https://en.wikipedia.org/wiki/Bohr_magneton
// In the Bohr model of the atom, for an electron that is in the orbit of lowest energy, its orbital angular momentum has magnitude equal to the reduced Planck constant, denoted ħ. The Bohr magneton is the magnitude of the magnetic dipole moment of an electron orbiting an atom with this angular momentum.

const BOHR_RADIUS = 5.29177210544e-11; // meters
// https://en.wikipedia.org/wiki/Bohr_radius
// The Bohr radius a₀ is a physical constant, approximately equal to the most probable distance between the nucleus and the electron in a hydrogen atom in its ground state. It is named after Niels Bohr, due to its role in the Bohr model of an atom. Its value is 5.29177210544(82)×10−11 m.

const BOLTZMANN = 1.380649e-23; // J*K^-1
const k = self::BOLTZMANN;
// https://en.wikipedia.org/wiki/Boltzmann_constant
// The Boltzmann constant (kB or k) is the proportionality factor that relates the average relative thermal energy of particles in a gas with the thermodynamic temperature of the gas. It occurs in the definitions of the kelvin and the gas constant, and in Planck's law of black-body radiation and Boltzmann's entropy formula, and is used in calculating thermal noise in resistors. The Boltzmann constant has dimensions of energy divided by temperature, the same as entropy.

const C = 299792458; // m/s
const c = self::C;
// https://en.wikipedia.org/wiki/Speed_of_light
// The speed of light in vacuum, commonly denoted c, is a universal physical constant that is exactly equal to 299,792,458 metres per second (approximately 300,000 kilometres per second; 186,000 miles per second; 671 million miles per hour).

const ELECTRIC_PERMITTIVITY = 8.8541878128e-12; // F / m
const EPSILON_ZERO = self::ELECTRIC_PERMITTIVITY;
const ε₀ = self::EPSILON_ZERO;
// https://en.wikipedia.org/wiki/Vacuum_permittivity
// Vacuum permittivity, commonly denoted ε₀ (pronounced "epsilon nought" or "epsilon zero"), is the value of the absolute dielectric permittivity of classical vacuum. It may also be referred to as the permittivity of free space, the electric constant, or the distributed capacitance of the vacuum.

const ELECTRON_MAGNETIC_DIPOLE_MOMENT = -9.2847647043e-24; // J/T
const μₑ = self::ELECTRON_MAGNETIC_DIPOLE_MOMENT;
// https://en.wikipedia.org/wiki/Electron_magnetic_moment
// In atomic physics, the electron magnetic moment, or more specifically the electron magnetic dipole moment, is the magnetic moment of an electron resulting from its intrinsic properties of spin and electric charge. The value of the electron magnetic moment (symbol μₑ) is −9.2847647043(28)×10−24 J⋅T−1. In units of the Bohr magneton (μB), it is −1.00115965218059(13) μB, a value that was measured with a relative accuracy of 1.3×10−13. 

const ELEMENTARY_CHARGE = 1.602176634e-19; // e*C
const e = self::ELEMENTARY_CHARGE;
// https://en.wikipedia.org/wiki/Elementary_charge
// The elementary charge, usually denoted by e, is a fundamental physical constant, defined as the electric charge carried by a single proton or, equivalently, the magnitude of the negative electric charge carried by a single electron, which has charge −1 e.

const G = 6.6743e-11; // N*m^2/kg^2
// https://en.wikipedia.org/wiki/Gravitational_constant
// The gravitational constant (also known as the universal gravitational constant, the Newtonian constant of gravitation, or the Cavendish gravitational constant), denoted by the capital letter G, is an empirical physical constant involved in the calculation of gravitational effects in Sir Isaac Newton's law of universal gravitation and in Albert Einstein's theory of general relativity.

const h = 6.62607015e-34; // J*Hz^−1
const PLANCK = self::h; // J*Hz^−1
// https://en.wikipedia.org/wiki/Planck_constant
// The Planck constant, or Planck's constant, denoted by h, is a fundamental physical constant of foundational importance in quantum mechanics: a photon's energy is equal to its frequency multiplied by the Planck constant, and the wavelength of a matter wave equals the Planck constant divided by the associated particle momentum.

const ℏ = 1.054571817e-34; // Js
const PLANCK_REDUCED = 1.054571817e-34;
// Plank constant over 2π

const MAGNETIC_PERMEABILITY = 1.25663706212e-6; // N/A^2
const μ₀ = self::MAGNETIC_PERMEABILITY;
const MU_ZERO = self::MAGNETIC_PERMEABILITY;
// https://en.wikipedia.org/wiki/Vacuum_permeability
// The vacuum magnetic permeability (variously vacuum permeability, permeability of free space, permeability of vacuum), also known as the magnetic constant, is the magnetic permeability in a classical vacuum. It is a physical constant, conventionally written as μ₀ (pronounced "mu nought" or "mu zero"). Its purpose is to quantify the strength of the magnetic field emitted by an electric current. Expressed in terms of SI base units, it has the unit kg⋅m⋅s−2·A−2. It can be also expressed in terms of SI derived units, N·A**−2. 
```
Usage example:
```php
use irrevion\science\Physics\Physics;
use irrevion\science\Physics\Entities\Quantity;
use irrevion\science\Physics\Entities\Particles\Electron;
use irrevion\science\Physics\Unit\Categories;
use irrevion\science\Physics\Unit\{SI, Planck, IAU, CGS, Natural, NonStandard, Imperial, USC};

$S = Physics::q(2.3e5, Planck::length);
$E = new Quantity(132, Natural::eV);
$rB = Physics::PLANCK_REDUCED / ( Electron::MASS * Physics::c * Physics::ALPHA );
```

## Quick overview

Methods available:
```php
Physics::unit($unit); // cast unit as array
Physics::convert(Entities\Quantity $v, mixed $to); // convert Quantity to another unit Quantity
Physics::q($value, Unit\SystemInterface $measure_unit); // autoconvert value from the given unit system, returns value in SI, allows to use values directly in equations as is
```

See also: [Quantity](docs/Physics/Entities/Quantity.md)