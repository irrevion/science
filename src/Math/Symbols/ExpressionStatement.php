<?php
namespace irrevion\science\Math\Symbols;

use irrevion\science\Math\Entities\{Scalar, NaN};
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};
use irrevion\science\Math\Symbols\Operations;


class ExpressionStatement {

	public $current_index = 0;
	public $length = 0;
	public $expression_statement = '';

	public $functions = ['avg', 'cos', 'exp'];
	public $operators = ['+', '-', '*', '/', '**', '^', '%', '='];
	public $map = [
		'func' => [
			'add' => 'Add',
		],
		'op' => [
			'+' => 'Add',
		]
	];

	public $stack = [
		'parsed' => [],
		//'yielding' => '',
		//'ops_tree' => []
	];
	public $parser_state = null;
	public $value = null;


	public function __construct($xpr) {
		$xpr = trim($xpr);
		if ($xpr==='') throw new \Error('Expression is empty');

		$this->length = strlen($xpr);
		$this->expression_statement = $xpr;
	}

	public function __toString() {
		if (!is_null($this->value)) {
			return "{$this->value}";
		}
		return "{$this->expression_statement}";
	}

	protected function printParsed($stack=null) {
		if (is_null($stack)) $stack = $this->stack['parsed'];
		$str = '';
		foreach ($stack as $v) {
			$str.="{$v['type']}:{$v['value']} ";
		}
		print $str."\n";
	}

	public function parse() {
		// print 'Parse started of '.$this->expression_statement."\n";
		$this->parser_state = 'running';
		while (!$this->completed()) {
			//print 'Check '.$this->expression_statement[$this->current_index]." at {$this->current_index}\n";
			$this->checkCurr();
			$this->next();
			//print "Next to {$this->current_index}\n";
		}
		//print "Parsing completed\n";
		if ($this->yielding()) $this->breakYield();
		$this->parser_state = 'completed';
		//$this->printParsed();

		$this->value = $this->craft($this->stack['parsed']);

		return $this;
	}

	public function isLast(): bool {
		return ($this->current_index===($this->length-1));
	}

	public function completed(): bool {
		// print "(({$this->current_index}>={$this->length}) || ({$this->parser_state}=='completed')) = ".((($this->current_index>=$this->length) || ($this->parser_state=='completed'))? 'true': 'false')." \n";
		return (($this->current_index>=$this->length) || ($this->parser_state=='completed'));
	}

	public function running(): bool {
		return ($this->parser_state=='running');
	}

	public function yielding(): bool {
		return in_array($this->parser_state, ['yield_num', 'yield_var', 'yield_op', 'yield_func']);
	}

	public function next() {
		$this->current_index++;
		return $this;
	}

	public function checkCurr() {
		$char = $this->expression_statement[$this->current_index];
		$char_kind = $this->getCharKind($char);
		$this->yield($char_kind, $char);
	}

	public function getCharKind(string $char): string {
		if (self::isWhitespace($char)) return 'space';
		if (self::isDigit($char)) return 'digit';
		if (self::isDecimalPoint($char)) return 'decimal_point';
		if (self::isOperator($char)) return 'operator';
		if (self::isLetter($char)) return 'letter';
		if (self::isSymbolic($char)) return 'symbolic';
		if (self::isUnderline($char)) return 'underline';
		if (self::isOpenCurlyBrace($char)) return 'open_curly_brace';
		if (self::isCloseCurlyBrace($char)) return 'close_curly_brace';
		if (self::isOpenParentesis($char)) return 'open_parentesis';
		if (self::isCloseParentesis($char)) return 'close_parentesis';
		if (self::isEqualSign($char)) return 'equal_sign';
		throw new \Error('Unexpected char '.$char.' at position '.$this->current_index);
	}

	public function yield($char_kind, $char) {
		if ($char_kind=='space') {
			if ($this->running()) {
				// skip spaces
				return;
			} else if ($this->yielding()) {
				$this->breakYield();
				return;
			}
		} else if ($char_kind=='digit') {
			if ($this->running()) {
				$this->startYieldNum($char);
				return;
			} else if ($this->yielding()) {
				if (in_array($this->parser_state, ['yield_num', 'yield_var', 'yield_func'])) {
					// ist okay to have symbol {k2} or function atan2()
					$this->keepYielding($char);
					return;
				} else if (in_array($this->parser_state, ['yield_op'])) {
					// digit after + or * is a new numeric entry
					$this->breakYield();
					$this->startYieldNum($char);
					return;
				}
			}
		} else if ($char_kind=='decimal_point') {
			if ($this->running()) {
				// accepts .2 numbers as 0.2
				$this->startYieldNum('0');
				$this->keepYieldingNum($char);
				return;
			} else if ($this->yielding()) {
				throw new \Error('Decimal point in not a number context');
			}
		} else if ($char_kind=='operator') {
			if ($this->running()) {
				if (in_array($char, ['+', '-'])) {
					if (($char==='+') && (empty($this->stack['parsed']) || ($this->lastParsedEntry()['type']=='operator'))) {
						// ignore + at starting position like in +36 / 12 case
						// alse ignore + after another operator like in 17**+3 or 6/+.01 case
						return;
					}
					if (($char==='-') && (empty($this->stack['parsed']) || ($this->lastParsedEntry()['type']=='operator'))) {
						// 2*-3 case
						$this->stackUp(['type' => 'operator', 'value' => 'Negative']);
						return;
					}
					$this->startYieldOp($char);
					return;
				} else if ($this->yielding()) {
					if (in_array($this->parser_state, ['yield_op'])) {
						$this->keepYieldingOp($char);
						return;
					} else if (in_array($this->parser_state, ['yield_num'])) {
						// in 2.71e-32 case (but not in 2.71e3-32 case) keep yielding num
						// if (in_array($char, ['+', '-']) && (substr($this->stack['yielding']['value'], -1)==='e')) {
						if (in_array($char, ['+', '-']) && (substr($this->lastParsedEntry('value'), -1)==='e')) {
							$this->keepYieldingNum($char);
							return;
						} else {
							$this->breakYield();
							$this->startYieldOp($char);
							return;
						}
					} else if (in_array($this->parser_state, ['yield_func'])) {
						$this->breakYield();
						$this->startYieldOp($char);
						return;
					} else if (in_array($this->parser_state, ['yield_var'])) {
						throw new \Error('Operator in variable context is illegal');
					}
				}
			}
		} else if (in_array($char_kind, ['letter', 'underline'])) {
			if ($this->running()) {
				$this->startYieldFunc($char);
				return;
			} else if ($this->yielding()) {
				if (in_array($this->parser_state, ['yield_num']) && ($char=='e')) {
					// for 4.9e-7 numbers
					$this->keepYielding($char);
					return;
				}
				if (in_array($this->parser_state, ['yield_num', 'yield_op'])) {
					$this->breakYield();
					$this->startYieldFunc($char);
					return;
				} else if (in_array($this->parser_state, ['yield_var', 'yield_func'])) {
					$this->keepYielding($char);
					return;
				}
			}
		} else if ($char_kind=='open_curly_brace') {
			if ($this->yielding()) $this->breakYield();
			$from = $this->current_index+1;
			$to = strpos($this->expression_statement, '}', $from);
			if ($to===false) throw new \Error('Closing curly brace not found');
			$len = $to-$from;
			$varname = substr($this->expression_statement, $from, $len);
			$this->stackUp(['type' => 'variable', 'value' => Symbols::symbol($varname)]);
			$this->current_index = $to;
		} else if ($char_kind=='open_parentesis') {
			if ($this->yielding()) $this->breakYield();
			$from = $this->current_index+1;
			$to = strpos($this->expression_statement, ')', $from);
			if ($to===false) throw new \Error('Closing parentesis not found');
			$len = $to-$from;
			// $sub_xpr = substr($this->expression_statement, $from, $to);
			$sub_xpr = substr($this->expression_statement, $from, $len);
			$this->stackUp(['type' => 'sub_expression', 'value' => Expressions::parse($sub_xpr)]);
			$this->current_index = $to;
		}
	}

	public function stackUp(array $entry): int {
		if (empty($entry['type']) || !in_array($entry['type'], ['number', 'variable', 'operator', 'function', 'sub_expression'])) {
			throw new \Error('Invalid type '.$entry['type'].'; cannot add entry to stack');
		}
		if (empty($entry['value'])) throw new \Error('Value should be provided');
		$this->stack['parsed'][] = $entry;
		return count($this->stack['parsed']);
	}

	public function lastParsedEntry(?string $key=null, mixed $value=null): array|null {
		$last_index = count($this->stack['parsed'])-1;
		$entry = ($this->stack['parsed'][$last_index] ?? null);

		if (!empty($value) && isset($this->stack['parsed'][$last_index])) {
			$this->stack['parsed'][$last_index]['value'] = $value;
		}

		if (!empty($key) && !empty($entry) && isset($entry[$key])) {
			return $entry[$key];
		}

		return $entry;
	}

	public function startYieldOp(string $char) {
		if ($this->yielding()) $this->breakYield();
		$this->parser_state = 'yield_op';
		$this->stackUp(['type' => 'operator', 'value' => $char]);
	}

	public function keepYieldingOp(string $char) {
		if ($this->lastParsedEntry('type')!='operator') throw new \Error('Operator yielding has not been started');
		if ($this->parser_state!='yield_op') throw new \Error('Operator yielding failed due to invalid parser state');
	}
	
	public function breakYield() {
		$entry = $this->lastParsedEntry();
		if ($this->parser_state=='yield_op') {
			if ($entry['type']!='operator') throw new \Error('Operator yielding has not been started; last parsed entry is '.$entry['type']);
			$op = (isset($this->map['op'][$entry['value']])? $this->map['op'][$entry['value']]: null);
			if (is_null($op)) throw new \Error('Unknown operator '.$op);
			$this->lastParsedEntry(value: $op); // set operation classname as operator value
		} else if ($this->parser_state=='yield_num') {
			if ($entry['type']!='number') throw new \Error('Number yielding has not been started');
			if (!is_numeric($entry['value'])) throw new \Error("{$entry['value']} is not a valid number");
			$num = $entry['value']*1;
			if ($num!=$entry['value']) throw new \Error("Seems like {$entry['value']} cannot be casted to a number properly ($num)");
			$num = Symbols::wrap($num, Scalar::class);
			$this->lastParsedEntry(value: $num); // set casted number as value
		} else {
			throw new \Error('Invalid parser state '.$this->parser_state);
		}
		$this->parser_state = 'running';
	}

	public function startYieldNum(string $char) {
		if ($this->yielding()) $this->breakYield();
		$this->parser_state = 'yield_num';
		$this->stackUp(['type' => 'number', 'value' => $char]);
	}

	// compose operations tree

	public function craft($stack) {
		if (empty($stack)) throw new \Error('Nothing is parsed');
		if (count($stack)===1) {
			$entry = $stack[0];
			if (in_array($entry['type'], ['number', 'variable'])) {
				return new Expression(Operations::op('NoOp')->over($entry['value']));
			} else if (in_array($entry['type'], ['function', 'sub_expression'])) {
				return $entry['value'];
			} else {
				throw new \Error('Operator requires operand to operate');
			}
		}

		$stack = $this->fillMissedMultiplications($stack);
		$stack = $this->craftUnaryOps($stack);
		$stack = $this->craftMultiplications($stack);
		$stack = $this->craftAdditions($stack);

		if ((count($stack)===1) && ($stack[0]['type']=='sub_expression') && ($stack[0]['value']::class==Expression::class)) {
			return $stack[0]['value'];
		}
		throw new \Error('Not able to craft valid expression, sorry');

		return null;
	}

	protected function fillMissedMultiplications($stack) {
		$new_stack = [];

		foreach ($stack as $i=>$entry) {
			$next = (isset($stack[$i+1])? $stack[$i+1]: null);
			$new_stack[] = $entry;
			if (is_null($next)) {break;}
			if (($entry['type']!='operator') && ($next['type']!='operator')) {
				$new_stack[] = ['type' => 'operator', 'value' => 'Multiply'];
			}
		}

		return $new_stack;
	}

	protected function craftUnaryOps($stack) {
		$new_stack = [];

		foreach ($stack as $i=>$entry) {
			$prev = (isset($stack[$i-1])? $stack[$i-1]: null);
			$next = (isset($stack[$i+1])? $stack[$i+1]: null);

			$new_stack[] = $entry;

			if ($entry['type']=='operator') {
				if (in_array($entry['value'], ['Negative'])) { // onward operators
					if (is_null($next) || ($next['type']=='operator')) throw new \Error('Expected symbol or expression after onward operator; '.$next['type'].' encountered');
					$xpr =  new Expression(Operations::op($entry['value'])->over($next['value']));
					$entry_to_replace = ['type' => 'sub_expression', 'value' => $xpr];
					array_splice($stack, $i, 2, [$entry_to_replace]);
					return $this->craftUnaryOps($stack);
				} else if (in_array($entry['value'], ['Factorial'])) { // afterward operators
					if (is_null($prev) || ($prev['type']=='operator')) throw new \Error('Expected symbol or expression prior to afterward operator; '.$prev['type'].' encountered');
					$xpr =  new Expression(Operations::op($entry['value'])->over($prev['value']));
					$entry_to_replace = ['type' => 'sub_expression', 'value' => $xpr];
					array_splice($stack, ($i-1), 2, [$entry_to_replace]);
					return $this->craftUnaryOps($stack);
				}
			}
		}

		return $new_stack;
	}

	protected function craftMultiplications($stack) {
		$new_stack = [];

		foreach ($stack as $i=>$entry) {
			$prev = (isset($stack[$i-1])? $stack[$i-1]: null);
			$next = (isset($stack[$i+1])? $stack[$i+1]: null);

			$new_stack[] = $entry;

			if ($entry['type']=='operator') {
				if (in_array($entry['value'], ['Multiply', 'Divide'])) {
					if (is_null($prev) || ($prev['type']=='operator')) throw new \Error('Expected symbol or expression before */ operator; '.$prev['type'].' encountered');
					if (is_null($next) || ($next['type']=='operator')) throw new \Error('Expected symbol or expression after */ operator; '.$next['type'].' encountered');
					$xpr =  new Expression(Operations::op($entry['value'])->over($prev['value'])->with($next['value']));
					$entry_to_replace = ['type' => 'sub_expression', 'value' => $xpr];
					array_splice($stack, ($i-1), 3, [$entry_to_replace]);
					return $this->craftMultiplications($stack);
				}
			}
		}

		return $new_stack;
	}

	protected function craftAdditions($stack) {
		$new_stack = [];

		foreach ($stack as $i=>$entry) {
			$prev = (isset($stack[$i-1])? $stack[$i-1]: null);
			$next = (isset($stack[$i+1])? $stack[$i+1]: null);

			$new_stack[] = $entry;

			if ($entry['type']=='operator') {
				if (in_array($entry['value'], ['Add', 'Subtract'])) {
					if (is_null($prev) || ($prev['type']=='operator')) throw new \Error('Expected symbol or expression before +- operator; '.$prev['type'].' encountered');
					if (is_null($next) || ($next['type']=='operator')) throw new \Error('Expected symbol or expression after +- operator; '.$next['type'].' encountered');
					$xpr =  new Expression(Operations::op($entry['value'])->over($prev['value'])->with($next['value']));
					$entry_to_replace = ['type' => 'sub_expression', 'value' => $xpr];
					array_splice($stack, ($i-1), 3, [$entry_to_replace]);
					return $this->craftAdditions($stack);
				}
			}
		}

		return $new_stack;
	}

	// static functions

	public static function isWhitespace(string $char): bool {
		return (preg_match('/[\pZ\pC]+/u', $char)===1);
	}

	public static function isDigit(string $char): bool {
		return (preg_match('/\d+/u', $char)===1);
	}

	public static function isDecimalPoint(string $char): bool {
		return ($char==='.');
	}

	public static function isOperator(string $char): bool {
		return in_array($char, ['+', '-', '*', '/', '^']);
	}

	public static function isLetter(string $char): bool {
		return (preg_match('/[a-zA-Z]+/u', $char)===1);
	}

	public static function isSymbolic(string $char): bool {
		return Symbols::isAllowedChar($char);
	}

	public static function isUnderline(string $char): bool {
		return ($char==='_');
	}

	public static function isOpenCurlyBrace(string $char): bool {
		return ($char==='{');
	}

	public static function isCloseCurlyBrace(string $char): bool {
		return ($char==='}');
	}

	public static function isOpenParentesis(string $char): bool {
		return ($char==='(');
	}

	public static function isCloseParentesis(string $char): bool {
		return ($char===')');
	}
}

?>