<?php

namespace net\dryuf\parse;


class Base64Url extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static function		convert($text)
	{
		return base64_decode(str_replace('-', '+', str_replace('_', '/', $text)));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		format($value)
	{
		return str_replace('+', '-', str_replace('/', '_', base64_encode($value)));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<byte[]>')
	*/
	public static function		convertList($text)
	{
		return \net\dryuf\util\Collections::transform(\net\dryuf\util\LinkedList::createFromArray(\net\dryuf\core\StringUtil::splitRegExp($text, "\\.")), 
			function ($s) {
				return \net\dryuf\parse\Base64Url::convert($s);
			}
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatList($list)
	{
		return \net\dryuf\core\StringUtil::join(".", 
			\net\dryuf\util\Collections::transform($list, 
				function ($v) {
					return \net\dryuf\parse\Base64Url::format($v);
				}
			));
	}
};


?>
