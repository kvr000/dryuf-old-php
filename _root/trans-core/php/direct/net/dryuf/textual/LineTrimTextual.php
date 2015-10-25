<?php

namespace net\dryuf\textual;


class LineTrimTextual extends \net\dryuf\textual\PreTrimTextual
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
		if (\net\dryuf\core\StringUtil::indexOf($internal, "\n") < 0) {
			return null;
		}
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\LineTrimTextual', "One line required.");
	}
};


?>
