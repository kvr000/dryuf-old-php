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
		if ($s === "")
			throw new \java\lang\StringIndexOutOfBoundsException(0);
		return strtoupper(strval(substr($s, 0, 1))).strval(substr($s, 1));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		uncapitalize($s)
	{
		return strtolower(strval(substr($s, 0, 1))).strval(substr($s, 1));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		joinArgs($sep, $input)
	{
		return \net\dryuf\core\StringUtil::joinArray($sep, $input);
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
	public static function		joinValidArgs($sep, $input)
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
	public static function		joinValid($sep, $input)
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
		$matcher = \java\util\regex\Pattern::compile($regexp)->matcher($text);
		if (!$matcher->matches())
			return null;
		$groups = \net\dryuf\core\Dryuf::allocArray(null, ($matcher->groupCount()+1));
		for ($i = 0; $i <= $matcher->groupCount(); $i++) {
			$groups[$i] = $matcher->group($i);
		}
		return $groups;
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

};

\net\dryuf\core\StringUtil::_initManualStatic();


?>
