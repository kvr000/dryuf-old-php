<?php

namespace net\dryuf\textual;


class TrimTextual extends \net\dryuf\textual\PreTrimTextual
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
		return $this->validate($text);
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
