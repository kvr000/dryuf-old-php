<?php

namespace net\dryuf\textual;


class UrlTextual extends \net\dryuf\textual\TrimRegexpTextual
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
		return "^http://((\\w+)\\.)+(\\w+)(/.*|)\$";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected function		getErrorMessage()
	{
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\UrlTextual', "URL required.");
	}
};


?>
