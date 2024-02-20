<?php
namespace irrevion\science\Math\Symbols;

use irrevion\science\Math\Entities\{Scalar, NaN};
use irrevion\science\Math\Symbols\{Symbols, Symbol, Expression};
use irrevion\science\Math\Symbols\Operations;


class ExpressionStatement {

	public $current_index = 0;
	public $length = 0;
	public $expression_statement = '';
	public $stack = [];
	public $parser_state = null;
	public $value = null;
	protected $parentesis = [];

	public static $debug = false;
	public static $functions = ['avg', 'cos', 'exp', 'ln'];
	public static $operators = ['+', '-', '*', '/', '**', '^', '!', '%', '='];
	public static $map = [
		'func' => [
			'abs' => 'Abs',
			'add' => 'Add',
			'avg' => 'Avg',
			'cos' => 'Cos',
			'divide' => 'Divide',
			'multiply' => 'Multiply',
			'pow' => 'Power',
			'sin' => 'Sin',
			'subtract' => 'Subtract',
		],
		'op' => [
			'+' => 'Add',
			'-' => 'Subtract',
			'*' => 'Multiply',
			'/' => 'Divide',
			'!' => 'Factorial',
			'**' => 'Power',
			'^' => 'Power',
		]
	];


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
		if (is_null($stack)) $stack = $this->stack;
		$str = '';
		foreach ($stack as $v) {
			$str.="{$v['type']}:{$v['value']} ";
		}
		print $str."\n";
	}

	public function parse() {
		if (self::$debug) print "\n\n\n Parse started of {$this->expression_statement} \n";
		$this->parser_state = 'running';
		$this->parentesis = self::parentesis($this->expression_statement);
		while (!$this->completed()) {
			//print 'Check '.$this->expression_statement[$this->current_index]." at {$this->current_index}\n";
			$this->checkCurr();
			$this->next();
			//print "Next to {$this->current_index}\n";
		}
		if (self::$debug) $this->printParsed();
		if (self::$debug) print "Parsing completed\n\n";
		if ($this->yielding()) $this->breakYield();
		$this->parser_state = 'completed';
		//if (self::$debug) $this->printParsed();

		$this->value = $this->craft($this->stack);
		if (is_string($this->value)) die($this->value);

		return $this;
	}

	public function isLast(): bool {
		return ($this->current_index===($this->length-1));
	}

	public function completed(): bool {
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
		if (self::$debug) $this->printParsed();
		if (self::$debug) print "yield $char_kind:'$char' \n";

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
				if (in_array($this->parser_state, ['yield_num'])) {
					if (strlen($this->lastParsedEntry('value'))===0) $this->startYieldNum('0');
					$this->keepYieldingNum($char);
					return;
				} else if (in_array($this->parser_state, ['yield_op', 'yield_var', 'yield_func'])) {
					$this->breakYield();
					$this->startYieldNum('0');
					$this->keepYieldingNum($char);
					return;
				}
			}
		} else if ($char_kind=='operator') {
			if ($this->running()) {
				if (in_array($char, ['+', '-'])) {
					if (($char==='+') && (empty($this->stack) || ($this->lastParsedEntry('type')=='operator'))) {
						// ignore + at starting position like in +36 / 12 case
						// also ignore + after another operator like in 17**+3 or 6/+.01 case
						// but DONT ignore + in case of 7.0!+3.0
						//print "(".$this->lastParsedEntry('value')."==='!') \n";
						if (in_array($this->lastParsedEntry('value'), ['!', 'Factorial'])) {
							$this->startYieldOp($char);
						}
						return;
					}
					if (($char==='-') && (empty($this->stack) || ($this->lastParsedEntry('type')=='operator'))) {
						// 2*-3 case
						$this->stackUp(['type' => 'operator', 'value' => 'Negative']);
						return;
					}
				}
				$this->startYieldOp($char);
				return;
			} else if ($this->yielding()) {
				if ($this->parser_state==='yield_op') {
					if (in_array($this->lastParsedEntry('value').$char, self::$operators)) {
						$this->keepYieldingOp($char);
					} else {
						$this->breakYield();
						if (($char==='-') && ($this->lastParsedEntry('type')=='operator')) {
							// 2*-3 case
							$this->stackUp(['type' => 'operator', 'value' => 'Negative']);
							return;
						}
						$this->startYieldOp($char);
					}
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
			if ($this->yielding() && ($this->parser_state!=='yield_func')) $this->breakYield();
			$from = $this->current_index+1;
			// $to = strrpos($this->expression_statement, ')', $from); // WRONG!!! if multiple subexpression or functions encountered
			$to = $this->parentesis[$this->current_index]['closes_at'];
			if ($to===false) throw new \Error('Closing parentesis not found');
			$len = $to-$from;
			// $sub_xpr = substr($this->expression_statement, $from, $to);
			$sub_xpr = substr($this->expression_statement, $from, $len);
			if ($this->parser_state==='yield_func') {
				$this->args($sub_xpr);
				$this->breakYield();
			} else {
				$this->stackUp(['type' => 'sub_expression', 'value' => Expressions::parse($sub_xpr)]);
			}
			$this->current_index = $to;
		}
	}

	public function stackUp(array $entry): int {
		if (empty($entry['type']) || !in_array($entry['type'], ['number', 'variable', 'operator', 'function', 'sub_expression'])) {
			throw new \Error('Invalid type '.$entry['type'].'; cannot add entry to stack');
		}
		if (is_null($entry['value']) || ($entry['value']==='')) throw new \Error('Value should be provided');
		$this->stack[] = $entry;
		return count($this->stack);
	}

	public function lastParsedEntry($key=null, $value=null) {
		$last_index = count($this->stack)-1;
		$entry = ($this->stack[$last_index] ?? null);

		if (!empty($value) && isset($this->stack[$last_index])) {
			$this->stack[$last_index]['value'] = $value;
		}

		if (!empty($key) && !empty($entry) && isset($entry[$key])) {
			return $entry[$key];
		}

		return $entry;
	}

	public function startYieldNum(string $char) {
		if ($this->yielding()) $this->breakYield();
		$this->parser_state = 'yield_num';
		$this->stackUp(['type' => 'number', 'value' => $char]);
	}

	public function keepYieldingNum(string $char) {
		$entry = $this->lastParsedEntry();
		if ($entry['type']!='number') throw new \Error('Number yielding has not been started');
		if ($this->parser_state!='yield_num') throw new \Error('Number yielding failed due to invalid parser state');
		$this->lastParsedEntry(value: ($entry['value'].=$char));
	}

	public function startYieldOp(string $char) {
		if ($this->yielding()) $this->breakYield();
		$this->parser_state = 'yield_op';
		$this->stackUp(['type' => 'operator', 'value' => $char]);
	}

	public function keepYieldingOp(string $char) {
		$entry = $this->lastParsedEntry();
		if ($entry['type']!='operator') throw new \Error('Operator yielding has not been started');
		if ($this->parser_state!='yield_op') throw new \Error('Operator yielding failed due to invalid parser state');
		$this->lastParsedEntry(value: ($entry['value'].=$char));
	}

	public function startYieldFunc(string $char) {
		if ($this->yielding()) $this->breakYield();
		$this->parser_state = 'yield_func';
		$this->stackUp(['type' => 'function', 'value' => $char]);
	}

	public function keepYieldingFunc(string $char) {
		$entry = $this->lastParsedEntry();
		if ($entry['type']!='function') throw new \Error('Function yielding has not been started');
		if ($this->parser_state!='yield_func') throw new \Error('Function yielding failed due to invalid parser state');
		$this->lastParsedEntry(value: ($entry['value'].=$char));
	}

	public function keepYielding(string $char) {
		switch ($this->parser_state) { // 'yield_num', 'yield_op', 'yield_var', 'yield_func'
			case 'yield_num': $this->keepYieldingNum($char); break;
			case 'yield_op': $this->keepYieldingOp($char); break;
			case 'yield_var': throw new \Error('Not implemented'); break;
			case 'yield_func': $this->keepYieldingFunc($char); break;
			default: throw new \Error('Invalid parser state; yielding failed');
		}
	}

	public function breakYield() {
		$entry = $this->lastParsedEntry();
		if ($this->parser_state=='yield_op') {
			if ($entry['type']!='operator') throw new \Error('Operator yielding has not been started; last parsed entry is '.$entry['type']);
			$op = (isset(self::$map['op'][$entry['value']])? self::$map['op'][$entry['value']]: null);
			// if (is_null($op)) {print $this->printParsed(); throw new \Error('Unknown operator '.$op);}
			if (is_null($op)) throw new \Error('Unknown operator '.$entry['value']);
			$this->lastParsedEntry(value: $op); // set operation classname as operator value
		} else if ($this->parser_state=='yield_num') {
			if ($entry['type']!='number') throw new \Error('Number yielding has not been started');
			if (!is_numeric($entry['value'])) throw new \Error("{$entry['value']} is not a valid number");
			$num = $entry['value']*1;
			if ($num!=$entry['value']) throw new \Error("Seems like {$entry['value']} cannot be casted to a number properly ($num)");
			$num = Symbols::wrap($num, Scalar::class);
			$this->lastParsedEntry(value: $num); // set casted number as value
		} else if ($this->parser_state=='yield_func') {
			if ($entry['type']!='function') throw new \Error('Function yielding has not been started; last parsed entry is '.$entry['type']);
			$op = (isset(self::$map['func'][$entry['value']])? self::$map['func'][$entry['value']]: null);
			if (is_null($op)) throw new \Error('Unknown function '.$entry['value']);
			$this->lastParsedEntry(value: $op); // set operation classname as operator value
		} else {
			throw new \Error('Invalid parser state '.$this->parser_state);
		}
		$this->parser_state = 'running';
	}

	public function args(string $args) {
		//print "Function arguments: $args \n";
		$params = [];
		$len = mb_strlen($args);
		$i = 0;
		$lookup_start_pos = $i;
		$offset = $this->current_index+1;
		while ($i<($len-1)) {
			$param_end_pos = strpos($args, ',', $i);
			if ($param_end_pos===false) { // only one param
				$p = substr($args, $lookup_start_pos);
				//var_export($p); print " at 385\n";
				$params[] = Expressions::parse($p);
				//print "param#".count($params)." found substr($args, $lookup_start_pos) = {$p} \n";
				break;
			} else { // more than one param
				$context_end_pos = strpos($args, '(', $i);
				if (($context_end_pos===false) || ($context_end_pos>$param_end_pos)) { // no rabbit holes here until param ends
					$p = substr($args, $lookup_start_pos, ($param_end_pos-$lookup_start_pos));
					//var_export($p); print " at 393; start $lookup_start_pos; length ".($param_end_pos-$lookup_start_pos)." ($param_end_pos-$lookup_start_pos) in $args\n";
					$params[] = Expressions::parse($p);
					//print "param#".count($params)." found substr(\"$args\", $lookup_start_pos, ($param_end_pos-$lookup_start_pos)) = {$p} \n";
					$i = $param_end_pos+1;
					$lookup_start_pos = $i;
					continue;
				} else {
					// rabbit hole is deep, jump over it
					$cur_pos = $offset+$i; // absolute char index
					$jump_start_pos = $offset+$context_end_pos;
					$jump_end_pos = $this->parentesis[$jump_start_pos]['closes_at'];
					$i = $jump_end_pos-$offset+1;
					//$lookup_start_pos = $i;
					continue;
				}
			}
			$i++;
		}

		// update parsed entry
		$last_stack_i = count($this->stack)-1;
		$fn = $this->stack[$last_stack_i];
		if (($fn['type']!='function') || ($this->parser_state!='yield_func')) throw new \Error('Last parsed entry is not a function or invalid parser state');
		$this->stack[$last_stack_i]['args'] = $params;
	}

	// compose operations tree

	public function craft($stack) {
		if (empty($stack)) throw new \Error('Nothing is parsed');
		if (count($stack)===1) {
			$entry = $stack[0];
			if (in_array($entry['type'], ['number', 'variable'])) {
				return new Expression(Operations::op('NoOp')->over($entry['value']));
			} else if (in_array($entry['type'], ['sub_expression'])) {
				return $entry['value'];
			}  else if (in_array($entry['type'], ['function'])) {
				$stack = $this->craftFuncs($stack);
				return $stack[0]['value'];
			} else {
				throw new \Error('Operator requires operand to operate');
			}
		}

		$stack = $this->craftFuncs($stack);
		$stack = $this->fillMissedMultiplications($stack);
		$stack = $this->craftUnaryOps($stack);
		$stack = $this->craftPow($stack);
		$stack = $this->craftMultiplications($stack);
		$stack = $this->craftAdditions($stack);

		if ((count($stack)===1) && ($stack[0]['type']=='sub_expression') && ($stack[0]['value']::class==Expression::class)) {
			return $stack[0]['value'];
		}
		/*
		print "{$stack[0]['value']}\n";
		if ($stack[1]['value']) {
			print "{$stack[1]['value']}\n";
		}
		*/
		//throw new \Error('Not able to craft valid expression, sorry ('.count($stack).' '.$stack[0]['type'].' '.$stack[0]['value']::class.')');
		throw new \Error('Not able to craft valid expression');

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

	protected function craftFuncs($stack) {
		$new_stack = [];

		foreach ($stack as $i=>$entry) {
			if ($entry['type']=='function') {
				$xpr = new Expression(Operations::op($entry['value'])->args(...$entry['args']));
				$entry_to_replace = ['type' => 'sub_expression', 'value' => $xpr];
				$new_stack[] = $entry_to_replace;
				continue;
			}
			$new_stack[] = $entry;
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
					$xpr = new Expression(Operations::op($entry['value'])->over($next['value']));
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

	protected function craftPow($stack) {
		$new_stack = [];

		foreach ($stack as $i=>$entry) {
			$prev = (isset($stack[$i-1])? $stack[$i-1]: null);
			$next = (isset($stack[$i+1])? $stack[$i+1]: null);

			$new_stack[] = $entry;

			if ($entry['type']=='operator') {
				if (in_array($entry['value'], ['Power'])) {
					if (is_null($prev) || ($prev['type']=='operator')) throw new \Error('Expected symbol or expression before (**|^) operator; '.$prev['type'].' encountered');
					if (is_null($next) || ($next['type']=='operator')) throw new \Error('Expected symbol or expression after (**|^) operator; '.$next['type'].' encountered');
					$xpr = new Expression(Operations::op($entry['value'])->over($prev['value'])->with($next['value']));
					$entry_to_replace = ['type' => 'sub_expression', 'value' => $xpr];
					array_splice($stack, ($i-1), 3, [$entry_to_replace]);
					return $this->craftPow($stack);
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
					if (is_null($prev) || ($prev['type']=='operator')) throw new \Error('Expected symbol or expression before (*|/) operator; '.$prev['type'].' encountered');
					if (is_null($next) || ($next['type']=='operator')) throw new \Error('Expected symbol or expression after (*|/) operator; '.$next['type'].' encountered');
					$xpr = new Expression(Operations::op($entry['value'])->over($prev['value'])->with($next['value']));
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
					if (is_null($prev) || ($prev['type']=='operator')) throw new \Error('Expected symbol or expression before (+|-) operator; '.$prev['type'].' encountered');
					if (is_null($next) || ($next['type']=='operator')) throw new \Error('Expected symbol or expression after (+|-) operator; '.$next['type'].' encountered');
					$xpr = new Expression(Operations::op($entry['value'])->over($prev['value'])->with($next['value']));
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
		// return in_array($char, ['+', '-', '*', '/', '**', '^', '!']);
		return in_array($char, self::$operators);
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

	public static function isEqualSign(string $char): bool {
		return ($char==='=');
	}

	public static function parentesis(string $expr) {
		$parentesis = [];
		$open = [];
		$close = [];
		$len = mb_strlen($expr);

		$offset = 0;
		while (($pos = strpos($expr, '(', $offset))!==false) {
			$open[] = $pos;
			$offset = $pos+1;
		}

		$offset = 0;
		while (($pos = strpos($expr, ')', $offset))!==false) {
			$close[] = $pos;
			$offset = $pos+1;
		}

		$n = count($open);
		if ($n!=count($close)) throw new \Error('Invalid parentesis encountered');
//(3-2)avg(-0.9, pow(5-6, 3), (abs({x}-1)*-1))
//print "Expression $expr \n";
//print "open parentesis positions:\n";
//print_r($open);
//print "close parentesis positions:\n";
//print_r($close);
//die();

		$stack = [];
		$i = 0;
		while (count($close)) {
			$open_pos = (count($open)? $open[0]: null);
			$close_pos = $close[0];
			$level = count($stack);
			if (($close_pos<$open_pos) && ($level===0)) throw new \Error('Unexpected closing parentesis at '.$close_pos);

			if (!is_null($open_pos) && ($close_pos>$open_pos)) { // we've found open pos
				$stack[] = array_shift($open);
				$level = count($stack);
				//print "open at ".end($stack)."; level $level \n";
			} else { // we've found closing pos
				$close_pos = array_shift($close);
				//print "close at $close_pos; level $level \n";
				$entry = array_pop($stack);
				$level = count($stack);
				$parentesis[$entry] = [
					'opens_at' => $entry,
					'closes_at' => $close_pos,
					'level' => $level
				];
			}

			$i++;
			if ($i>1000) throw new \Error('You spin my head right round, right round...');
		}

		return $parentesis;
	}
}

?>