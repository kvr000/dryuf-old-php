<?php

namespace net\dryuf\textual;


class TextualManager extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Textual')
	*/
	public static function		createTextual($clazz, $callerContext)
	{
		try {
			return \net\dryuf\core\Dryuf::createClassArg0($clazz)->setCallerContext($callerContext);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\Textual<java\lang\Object>')
	*/
	public static function		createTextualUnsafe($clazz, $callerContext)
	{
		try {
			return \net\dryuf\core\Dryuf::createClassArg0($clazz)->setCallerContext($callerContext);
		}
		catch (\net\dryuf\core\Exception $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		convertTextual($clazz, $callerContext, $text)
	{
		$textual = \net\dryuf\textual\TextualManager::createTextual($clazz, $callerContext);
		$text = $textual->prepare($text, null);
		if (!is_null(($err = $textual->check($text, null))))
			throw new \net\dryuf\core\RuntimeException($err);
		return $textual->convert($text, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		convertTextualUnsafe($clazz, $callerContext, $text)
	{
		$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($clazz, $callerContext);
		$text = $textual->prepare($text, null);
		if (!is_null(($err = $textual->check($text, null))))
			throw new \net\dryuf\core\RuntimeException($err);
		return $textual->convert($text, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatTextual($clazz, $callerContext, $internal)
	{
		$textual = \net\dryuf\textual\TextualManager::createTextual($clazz, $callerContext);
		return $textual->format($internal, null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatTextualUnsafe($clazz, $callerContext, $internal)
	{
		$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($clazz, $callerContext);
		return $textual->format($internal, null);
	}
};


?>
