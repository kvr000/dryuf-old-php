<?php

namespace net\dryuf\textual;


class FloatTextual extends \net\dryuf\textual\ConvertRegexpTextual
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
		try {
			\net\dryuf\core\Dryuf::parseFloat($text);
			return null;
		}
		catch (\net\dryuf\core\NumberFormatException $ex) {
			return $this->callerContext->getUiContext()->localize('net\dryuf\textual\FloatTextual', "Real number required.");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Float')
	*/
	public function			convertInternal($text, $style)
	{
		return \net\dryuf\core\Dryuf::parseFloat($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Float')
	*/
	public function			convertKeyInternal($text)
	{
		return \net\dryuf\core\Dryuf::parseFloat($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		if (!(is_float($internal))) {
			return $this->callerContext->getUiContext()->localize('net\dryuf\textual\FloatTextual', "Real number required.");
		}
		return null;
	}
};


?>
