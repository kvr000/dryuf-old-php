<?php

namespace net\dryuf\textual;


class PreTrimTextual extends \net\dryuf\textual\AbstractTextual
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
