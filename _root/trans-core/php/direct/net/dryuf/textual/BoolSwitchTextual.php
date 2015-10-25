<?php

namespace net\dryuf\textual;


class BoolSwitchTextual extends \net\dryuf\textual\PreTrimTextual
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
	public function			validate($internal)
	{
		if (is_bool($internal))
			return null;
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\BoolSwitchTextual', "Bool value required.");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			check($text, $style)
	{
		if (!\net\dryuf\core\StringUtil::matchRegExp($text, "^([01]|true|false)\$"))
			return $this->callerContext->getUiContext()->localize('net\dryuf\textual\BoolSwitchTextual', "Bool value required.");
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			format($internal, $style)
	{
		return $internal ? "true" : "false";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	*/
	public function			convertInternal($text, $style)
	{
		if (($text === "true"))
			return true;
		elseif (($text === "false"))
			return false;
		else
			return \net\dryuf\core\Dryuf::parseInt($text) != 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	*/
	public function			convertKeyInternal($text)
	{
		return \net\dryuf\core\Dryuf::parseInt($text) != 0;
	}
};


?>
