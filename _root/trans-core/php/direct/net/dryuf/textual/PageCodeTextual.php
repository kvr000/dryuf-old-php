<?php

namespace net\dryuf\textual;


class PageCodeTextual extends \net\dryuf\textual\SimpleRegexpTextual
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
		return "^[a-z]+\$";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getErrorMessage()
	{
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\PageCodeTextual', "Page code (word) required");
	}
};


?>
