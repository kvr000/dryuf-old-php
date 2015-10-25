<?php

namespace net\dryuf\textual;


class DotIdentifierTextual extends \net\dryuf\textual\SimpleRegexpTextual
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
		return "^([a-zA-Z]\\w+\\.)*[a-zA-Z]\\w+\$";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		getErrorMessage()
	{
		return $this->getUiContext()->localize('net\dryuf\textual\WordTextual', "Dot identifier (words separated by .) required.");
	}
};


?>
