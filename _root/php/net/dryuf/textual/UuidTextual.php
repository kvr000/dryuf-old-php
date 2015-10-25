<?php

namespace net\dryuf\textual;


class UuidTextual extends \net\dryuf\textual\SimpleRegexpTextual
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
	protected function		getRegexp()
	{
		return "^([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})\$";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		getErrorMessage()
	{
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\UuidTextual', "UUID in format xxxxxxxx-yyyy-zzzz-vvvv-wwwwwwwwwwww required");
	}
};


?>
