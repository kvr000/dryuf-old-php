<?php

namespace net\dryuf\textual;


abstract class TrimRegexpTextual extends \net\dryuf\textual\SimpleRegexpTextual
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
	public function			prepare($text, $style)
	{
		return trim($text);
	}
};


?>
