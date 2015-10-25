<?php

namespace net\dryuf\textual;


abstract class DateTimeBaseTextual extends \net\dryuf\textual\DirectKeyPreTrimTextual
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			convertKeyInternal($text)
	{
		return \net\dryuf\core\Dryuf::parseInt($text);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			validate($internal)
	{
		return is_int($internal) ? null : $this->callerContext->getUiContext()->localize('net\dryuf\textual\DateTimeBaseTextual', "Invalid internal date type");
	}
};


?>
