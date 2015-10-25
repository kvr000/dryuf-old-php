<?php

namespace net\dryuf\textual;


abstract class SimpleRegexpTextual extends \net\dryuf\textual\AbstractTextual
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
		if (!\net\dryuf\core\StringUtil::matchRegExp($text, $this->getRegexp()))
			return $this->getErrorMessage();
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		if (!\net\dryuf\core\StringUtil::matchRegExp($internal, $this->getRegexp()))
			return $this->getErrorMessage();
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected abstract function	getRegexp();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected abstract function	getErrorMessage();
};


?>
