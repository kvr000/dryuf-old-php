<?php

namespace net\dryuf\core;


class StringUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public static			$STRING_EMPTY_ARRAY;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		capitalize($s)
	{
		return \ucfirst($s);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		uncapitalize($s)
	{
		return \lcfirst($s);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		joinArgs($sep)
	{
		$input = func_get_args();
		array_shift($input);
		return self::joinArray($sep, $input);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		joinArray($sep, $input)
	{
		if (count($input) == 0)
			return "";
		$out = new \net\dryuf\core\StringBuilder($input[0]);
		for ($i = 1; $i < count($input); $i++)
			$out->append($sep)->append($input[$i]);
		return strval($out);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		join($sep, $input)
	{
		$out = new \net\dryuf\core\StringBuilder();
		foreach ($input as $s) {
			$out->append($s)->append($sep);
		}
		$l = $out->length();
		if ($l == 0)
			return "";
		$out->replace($l-strlen($sep), $l, "");
		return strval($out);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		joinEscaped($escaper, $sep, $input)
	{
		$counter = 0;
		$out = new \net\dryuf\core\StringBuilder();
		foreach ($input as $s) {
			if ($counter++ > 0)
				$out->append($sep);
			$out->append(call_user_func($escaper, $s));
		}
		return strval($out);
	}

	/**
	 * Concatenates arguments of strings, ignoring nulls.
	 * 
	 * @param sep
	 * 	string to separate entries
	 * @param input
	 * 	list of strings to concatenate
	 * 
	 * @return
	 * 	concatenated strings
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		joinValidArgs($sep)
	{
		$input = func_get_args();
		array_shift($input);
		$found = 0;
		$out = new \net\dryuf\core\StringBuilder();
		for ($i = 0; $i < count($input); $i++) {
			$s = $input[$i];
			if (is_null($s))
				continue;
			if ($found++ > 0)
				$out->append($sep);
			$out->append($s);
		}
		return strval($out);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		joinValid($sep, $input)
	{
		return \net\dryuf\core\StringUtil::joinValidArray($sep, $input);
	}

	/**
	 * Concatenates array of strings, ignoring nulls.
	 * 
	 * @param sep
	 * 	string to separate entries
	 * @param input
	 * 	list of strings to concatenate
	 * 
	 * @return
	 * 	concatenated strings
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		joinValidArray($sep, $input)
	{
		$found = 0;
		$out = new \net\dryuf\core\StringBuilder();
		foreach ($input as $s) {
			if (is_null($s))
				continue;
			if ($found++ > 0)
				$out->append($sep);
			$out->append($s);
		}
		return strval($out);
	}

	/**
	 * Concatenates collection of strings, ignoring nulls.
	 * 
	 * @param sep
	 * 	string to separate entries
	 * @param input
	 * 	list of strings to concatenate
	 * 
	 * @return
	 * 	concatenated strings
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		joinValidEscaped($escaper, $sep, $input)
	{
		$found = 0;
		$out = new \net\dryuf\core\StringBuilder();
		foreach ($input as $s) {
			if (is_null($s))
				continue;
			if ($found++ > 0)
				$out->append($sep);
			$out->append(call_user_func($escaper, $s));
		}
		return strval($out);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		defaultIfEmpty($s, $defaultValue)
	{
		return is_null($s) || $s === "" ? $defaultValue : $s;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	public static function		matchText($regexp, $text)
	{
		if (!preg_match("/".str_replace("/", "\\/", $regexp)."/", $text, $match))
			return null;
		return $match;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		matchNeedGroup($regexp, $text)
	{
		$groups = \net\dryuf\core\StringUtil::matchText($regexp, $text);
		if (is_null($groups) || count($groups) < 2)
			throw new \net\dryuf\core\IllegalArgumentException("Failed to match '".$text."' on '".$regexp."'.");
		return $groups[1];
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		matchNeedGroupSpecific($regexp, $text, $group)
	{
		$groups = \net\dryuf\core\StringUtil::matchText($regexp, $text);
		if (is_null($groups) || count($groups) <= $group)
			throw new \net\dryuf\core\IllegalArgumentException("Failed to match '".$text."' on '".$regexp."'.");
		return $groups[$group];
	}

	public static function		_initManualStatic()
	{
		self::$STRING_EMPTY_ARRAY = array();
	}

	public static function		indexOf($str, $needle, $start = 0)
	{
		if (($r = strpos($str, $needle, $start)) === false)
			$r = -1;
		return $r;
	}

	public static function		lastIndexOf($str, $needle, $start = 0x7fffffff)
	{
		$str = substr($str, 0, $start+strlen($needle));
		if (($r = strrpos($str, $needle, 0)) === false)
			$r = -1;
		return $r;
	}

	public static function		matchRegExp($str, $re)
	{
		$re = str_replace("/", "\\/", $re);
		return preg_match("/$re/", $str);
	}

	public static function		replaceRegExp($str, $re, $sub)
	{
		$re = str_replace("/", "\\/", $re);
		return preg_replace("/$re/", $sub, $str);
	}

	public static function		splitRegExp($str, $re)
	{
		$re = str_replace("/", "\\/", $re);
		return preg_split("/$re/", $str);
	}

};

\net\dryuf\core\StringUtil::_initManualStatic();


?>
