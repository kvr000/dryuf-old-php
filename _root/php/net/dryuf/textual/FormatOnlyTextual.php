<?php

namespace net\dryuf\textual;


abstract class FormatOnlyTextual extends \net\dryuf\textual\AbstractTextual
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
	public function			check($text, $style)
	{
		throw new \net\dryuf\core\RuntimeException("format only");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			convertInternal($text, $style)
	{
		throw new \net\dryuf\core\RuntimeException("format only");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			convertKeyInternal($text)
	{
		throw new \net\dryuf\core\RuntimeException("format only");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		throw new \net\dryuf\core\RuntimeException("format only");
	}
};


?>
