<?php
namespace irrevion\science\Math\Symbols;

use irrevion\science\Helpers\Delegator;
use irrevion\science\Math\Math;
use irrevion\science\Math\Entities\{Scalar, NaN};
use irrevion\science\Math\Symbols\{Symbol, Expression};
use irrevion\science\Physics\Physics;


class Symbols {
	// static symbols factory and registry class

	public static $alphabet = [
		'abcdfgjklmnopqrstuvwxyz',
		'ABCDEFGHIKLMNOPQRSTUVWXYZ',
		'áàâäăāãåąæɒɐɓɔćċčçĉɕďʗɗðđɖʤʣʥéèėêëěĕēɜɞęɝʚɚʩɘəɠġĝğģɤɢʛɥʮɧɦĦħʯʜìîïĭīĩįɩɪɫĵʝʄɟĳkʞķʟɭʪɮʫɱɯɰŉńňñņŋɴɳɲóôòöŏōõőœɶŕɹɺřŗɻʁɾɿɽśŝšşʂßʃʅʆſťʇʧÞţʨʈŧʦúùûüŭūũůųʉűŵýŷÿźʐʑżžʒʓ',
		'ÁÀÂÄĂĀÃÅĄÆBĆĊĎÐEÉÈĖÊËĚĔĒĘĠĜĞĢĤÍÌİÎÏĬĪĨĮĲĴĶĹĿĽĻŁľļɬŃŇÑŅŊÓÒÔÖŎŌÕŐŔŘŖŚŜŠŞŤŢŦÚÙÛÜŬŪŨŮŲŰŴÝŶŹŻŽ',
		'ᾰᾱβγδεζηθικλμνξρῥςσυϑϋῡῠὺύφχψωϖͼͽϙ',
		'ΔΘΛΞΨΩὩὨΏῺῼὭὫ℧',
	];
	public static $modificators = '₀₁₂₃₄₅₆₇₈₉ₐₑₒₓₔₕₖₗₘₙₚₛₜ';
	public static $numbers = '0123456789';
	public static $registry = [];

	public static function let(string|array $names): Symbol|array {
		if (is_string($names)) return self::takeName($names);
		if (is_array($names)) {
			$symbols = [];
			foreach ($names as $n) {
				$symbols[] = self::takeName($n);
			}
			return $symbols;
		}
	}
	public static function define(...$args) {return self::let(...$args);}

	public static function takeName(string $name, ?Symbol $symbol=null): Symbol {
		if (self::isNameTaken($name)) throw new \Error("Name {$name} is taken; Symbol name cannot be reused");
		if (is_null($symbol)) {
			$symbol = new Symbol($name);
		} else {
			self::$registry[$name] = $symbol;
		}
		return $symbol;
	}

	public static function isNameTaken(string $name): bool {
		return isset(self::$registry[$name]);
	}

	public static function isAllowedChar(string $char): bool {
		$all = str_split(implode('', self::$alphabet));
		return in_array($char, $all);
	}

	public static function free(string|array $names): void {
		if (is_string($names)) unset(self::$registry[$names]);
		if (is_array($names)) foreach ($names as $n) {self::free($n);}
	}

	public static function suggestName(): string {
		$simple_names = str_split(self::$alphabet[0].self::$alphabet[1]);
		$left = array_diff($simple_names, array_keys(self::$registry));
		if (count($left)) {
			return $left[array_rand($left)];
		}

		$name = $simple_names[array_rand($simple_names)].self::$modificators[array_rand(self::$modificators)];
		if (!isset(self::$registry[$name])) {
			return $name;
		}

		$all = str_split(implode('', self::$alphabet));
		do {
			shuffle($all);
			$name = $all[0].$all[1].$all[3].(shuffle(self::$modifiers)[0]);
		} while (isset(self::$registry[$name]));
		return $name;
	}

	public static function suggestExpressionName(): string {
		$name = 'Expr_';
		$nums = str_split(self::$numbers);
		do {
			shuffle($nums);
			$name.=$nums[array_rand($nums)];
		} while (isset(self::$registry[$name]));
		return $name;
	}

	public static function suggestConstName(): string {
		$name = 'Const_';
		$nums = str_split(self::$numbers);
		do {
			shuffle($nums);
			$name.=$nums[array_rand($nums)];
		} while (isset(self::$registry[$name]));
		return $name;
	}

	public static function symbol(string $name): Symbol {
		if (self::isNameTaken($name)) return self::$registry[$name];
		return self::takeName($name);
	}

	public static function const($value): Symbol {
		return self::takeName(self::suggestConstName())->assign($value)->asConst();
	}

	public static function wrap(mixed $value, ?string $cast_to=null): Symbol|Expression {
		// wrap variable value to Symbol
		$type = Delegator::getType($value);
		if (in_array($type, [Symbol::class, Expression::class])) return $value; // already symbol

		if (is_string($value)) return self::symbol($value);

		// if (!is_null($cast_to)) $value = Delegator::wrap($value);
		if (!is_null($cast_to)) {
			$value = Delegator::wrap($value, $cast_to);
		}

		return Symbols::const($value);
	}

	public static function default() {
		$symbols = [];
		$symbols[] = self::takeName('π')->assign(Math::PI);
		$symbols[] = self::takeName('τ')->assign(Math::TAU);
		$symbols[] = self::takeName('e')->assign(Math::E);
		$symbols[] = self::takeName('i')->assign(new \irrevion\science\Math\Entities\Imaginary(1));
		$symbols[] = self::takeName('α')->assign(Physics::α);
		$symbols[] = self::takeName('c')->assign(Physics::c);
		$symbols[] = self::takeName('G')->assign(Physics::G);
		$symbols[] = self::takeName('h')->assign(Physics::h);
		$symbols[] = self::takeName('ℏ')->assign(Physics::ℏ);
		return $symbols;
	}
}
Symbols::default();

// ln( 1e2 - 99 / ( 1 + e**-3{x}))
?>