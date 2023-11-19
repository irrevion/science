<?php
namespace irrevion\science\Physics\Unit\Entities;

class Parsec implements Length, IAU { // stands for Parallax ARcSECond
	const name = 'parsec';
	const short_name = 'pc';
	// const category = 'length'; // defined by interface
	// const unit_system = 'IAU'; // defined by interface
	const measure = 'pc';
	const reference = 3.0856775814913673e16;
	const reference_measure = 'm';
	const alias = 'L';
	const descr = 'A parsec is the distance from the Sun to an astronomical object that has a parallax angle of one arcsecond. The parsec (symbol: pc) is a unit of length used to measure the large distances to astronomical objects outside the Solar System, approximately equal to 3.26 light-years or 206,265 astronomical units (AU), i.e. 30.9 trillion kilometres (19.2 trillion miles). The parsec unit is obtained by the use of parallax and trigonometry, and is defined as the distance at which 1 AU subtends an angle of one arcsecond (1/3600 of a degree).';
	const base = '';
}
?>