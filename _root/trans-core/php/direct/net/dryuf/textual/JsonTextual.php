<?php

namespace net\dryuf\textual;


class JsonTextual extends \net\dryuf\textual\TextTextual
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
		throw new \net\dryuf\core\RuntimeException("todo");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			convert($text, $style)
	{
		throw new \net\dryuf\core\RuntimeException("todo");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal, $style)
	{
		throw new \net\dryuf\core\RuntimeException("todo");
	}
};


?>
