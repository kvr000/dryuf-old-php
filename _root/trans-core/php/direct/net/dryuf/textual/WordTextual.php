<?php

namespace net\dryuf\textual;


class WordTextual extends \net\dryuf\textual\SimpleRegexpTextual
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
		return "^\\w+\$";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		getErrorMessage()
	{
		return $this->getUiContext()->localize('net\dryuf\textual\WordTextual', "Single word required.");
	}
};


?>
