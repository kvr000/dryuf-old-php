<?php

namespace net\dryuf\textual;


class DoubleTextual extends \net\dryuf\textual\ConvertRegexpTextual
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
			\net\dryuf\core\Dryuf::parseDouble($text);
			return null;
		}
		catch (\net\dryuf\core\NumberFormatException $ex) {
			return $this->callerContext->getUiContext()->localize('net\dryuf\textual\DoubleTextual', "Real number required.");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Double')
	*/
	public function			convertInternal($text, $style)
	{
		return \net\dryuf\core\Dryuf::parseDouble($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Double')
	*/
	public function			convertKeyInternal($text)
	{
		return \net\dryuf\core\Dryuf::parseDouble($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		if (!(is_float($internal))) {
			return $this->callerContext->getUiContext()->localize('net\dryuf\textual\DoubleTextual', "Real number required.");
		}
		return null;
	}
};


?>
