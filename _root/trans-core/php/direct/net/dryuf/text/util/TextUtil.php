<?php

namespace net\dryuf\text\util;


class TextUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		transliterate($text)
	{
		return (=f_I_x=)org.apache.commons.lang3.StringUtils.stripAccents(text)(=x_I_f=);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		convertNameToDisplay($name)
	{
		$name = strtolower($name);
		$name = \net\dryuf\text\util\TextUtil::transliterate($name);
		$name = \net\dryuf\core\StringUtil::replaceRegExp($name, "\\s", "-");
		$name = \net\dryuf\core\StringUtil::replaceRegExp($name, "--+", "-");
		$name = \net\dryuf\core\StringUtil::replaceRegExp($name, "(^-+|-+\$)", "");
		return $name;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		generateCode($length)
	{
		$out = implode(array_map('chr', \net\dryuf\core\Dryuf::allocArray(0, $length)));
		for ($i = 0; $i < strlen($out); $i++)
			$out[$i] = chr(ord(self::$CODE_CHARS[mt_rand(0, strlen(self::$CODE_CHARS)-1)]));
		return ($out);
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static			$CODE_CHARS;

	public static function		_initManualStatic()
	{
		self::$CODE_CHARS = implode(array_map('chr', array( ord('2'), ord('3'), ord('4'), ord('5'), ord('6'), ord('7'), ord('8'), ord('9'), ord('A'), ord('B'), ord('D'), ord('E'), ord('F'), ord('G'), ord('H'), ord('J'), ord('M'), ord('N'), ord('Q'), ord('R'), ord('T'), ord('a'), ord('b'), ord('d'), ord('e'), ord('f'), ord('h'), ord('i'), ord('j'), ord('m'), ord('n'), ord('q'), ord('r'), ord('t') )));
	}

};

\net\dryuf\text\util\TextUtil::_initManualStatic();


?>
