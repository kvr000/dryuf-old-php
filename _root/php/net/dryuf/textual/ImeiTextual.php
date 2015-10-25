<?php

namespace net\dryuf\textual;


class ImeiTextual extends \net\dryuf\textual\SimpleRegexpTextual
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
	public function			getRegexp()
	{
		return "^[0-9]{14}\$";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getErrorMessage()
	{
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\ImeiTextual', "14 IMEI digits required");
	}
};


?>
