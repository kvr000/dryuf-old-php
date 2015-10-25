<?php

namespace net\dryuf\textual;


class DotClassnameTextual extends \net\dryuf\textual\AbstractTextual
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
		if (is_null(\net\dryuf\core\StringUtil::matchText("^((\\w+\\.)*\\w+)\$", $text))) {
			return $this->getUiContext()->localize('net\dryuf\textual\DotClassnameTextual', "Classname (dotted) required");
		}
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		if (is_null(\net\dryuf\core\StringUtil::matchText("^((\\w+\\.)*\\w+)\$", $internal))) {
			return $this->getUiContext()->localize('net\dryuf\textual\DotClassnameTextual', "Classname (dotted) required");
		}
		return null;
	}
};


?>
