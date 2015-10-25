<?php

namespace net\dryuf\textual;


class IntegerTextual extends \net\dryuf\textual\PreTrimTextual
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
			return $this->validate(\net\dryuf\core\Dryuf::parseInt($text));
		}
		catch (\net\dryuf\core\NumberFormatException $ex) {
			return $this->callerContext->getUiContext()->localize('net\dryuf\textual\IntegerTextual', "Number required");
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Integer')
	*/
	public function			convertInternal($text, $style)
	{
		try {
			return \net\dryuf\core\Dryuf::parseInt($text);
		}
		catch (\net\dryuf\core\NumberFormatException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}
};


?>
