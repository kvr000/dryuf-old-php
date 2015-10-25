<?php

namespace net\dryuf\textual;


class PhoneTextual extends \net\dryuf\textual\TrimRegexpTextual
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
		$text = parent::prepare($text, $style);
		if (!is_null(($groups = \net\dryuf\core\StringUtil::matchText("^00(\\d+)\$", $text))))
			$text = "+".$groups[1];
		return $text;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRegexp()
	{
		return "^\\+\\d+\$";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getErrorMessage()
	{
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\PhoneTextual', "Phone number in international format 00xyz... required");
	}
};


?>
