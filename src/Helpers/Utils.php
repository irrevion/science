<?php
namespace irrevion\science\Helpers;

class Utils {

	public static function bigint2string($bigint) {
		return sprintf('%.0f', $bigint);
	}

	public static function variableHasValue($var) {
		return !(empty($var) && ($var!=='0') && ($var!==false));
	}

	public static function isEmptyArrayRecursive($arr, $zerosAreValue=1) {
		if (empty($arr) && (!$zerosAreValue || ($zerosAreValue && !self::variableHasValue($arr)))) {return true;}
		if (is_array($arr)) {
			foreach ($arr as $key=>$val) {
				if (!self::isEmptyArrayRecursive($val, $zerosAreValue)) {
					return false;
				}
			}
			return true;
		}
		return false;
	}

	public function arrayIsAssoc($arr) {
		return (count(array_filter(array_keys($arr), 'is_string'))>0);
	}

	public static function arrayFilterKeys($arr, $keys, $skip_empty_values=true) {
		$keys_num = count($keys);
		if (!$keys_num || !is_array($arr) || !is_array($keys)) {return [];}
		$res = [];
		foreach ($keys as $k) {
			if ($skip_empty_values && !isset($arr[$k])) {continue;}
			$res[$k] = (isset($arr[$k])? $arr[$k]: '');
		}

		return $res;
	}

	public static function arrayExcludeKeys($arr, $keys) {
		return self::arrayFilterKeys($arr, array_diff(array_keys($arr), $keys));
	}

	public static function array_divide($array, $parts=1) {
		$parts = intval($parts);
		if (($parts<=1)) {return $array;}
		$total = count($array);
		if ($total<=$parts) {
			$result = [];
			foreach ($array as $item) {$result[] = [$item];}
			array_pad($result, $parts, []);
			return $result;
		}
		$rows = $total/$parts;
		$size = ceil($rows);
		$nobr_rows = floor($rows);
		$solid = $nobr_rows*$parts;
		$remains = $total-$solid;
		if (($size==$solid) || ($remains==($parts-1))) {
			return array_chunk($array, $size);
		} else {
			$result = [];
			$i=0;
			$offset=0;
			while ($i<$parts) {
				$length = (($remains>0)? ($nobr_rows+1): $nobr_rows);
				$result[$i] = array_slice($array, $offset, $length);
				$offset+=$length;
				$remains--;
				$i++;
			}
			return $result;
		}
	}

	public static function arrayAttributesToColumns(array $attributes_list): array {
		// Transforms numeric array with assotiative arrays in values
		// to associative array with numeric arrays as items
		if (!is_array($attributes_list)) {
			throw new \Error('Argument type is not an array');
		} else {
			$columns_list = [];
			foreach ($attributes_list as $attributes) {
				foreach ($attributes as $column=>$value) {
					$columns_list[$column][] = $value;
				}
			}
		}
		return $columns_list;
	}

	public static function arrayColumnsToAttributes(array $columns_list): array {
		// Transforms associative array with numeric arrays in values
		// to numeric array with associative arrays as items
		if (!is_array($columns_list)) {
			throw new \Error('Argument type is not an array');
		} else {
			$attributes_list = [];
			foreach ($columns_list as $column=>$row) {
				foreach ($row as $i=>$value) {
					$attributes_list[$i][$column] = $value;
				}
			}
		}
		return $attributes_list;
	}

	public static function arraySortByCol($arr, $col) {
		$by = [];
		foreach ($arr as $key=>$value) {
			$by[$key] = $value[$col];
		}
		array_multisort($by, SORT_ASC, SORT_STRING, $arr);
		return $arr;
	}

	public static function printR($arr) {
		if (is_iterable($arr)) {
			$str = "";
			foreach ($arr as $v) {
				$str.=(strlen($str)? ', ': '').self::printR($v);
			}
			return "[$str]";
		}
		return "$arr";
	}
}