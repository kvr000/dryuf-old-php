<?php

namespace net\dryuf\textual;


class SlashedClassnameTextual extends \net\dryuf\textual\AbstractTextual
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
	public function			validate($internal)
	{
		if (is_null(\net\dryuf\core\StringUtil::matchText("^((\\w+/)*\\w+)\$", $internal))) {
			return $this->getUiContext()->localize('net\dryuf\textual\SlashedClassnameTextual', "Classname (slashed) required.");
		}
		return null;
	}
};


?>
