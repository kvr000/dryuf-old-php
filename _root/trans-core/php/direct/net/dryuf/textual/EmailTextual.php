<?php

namespace net\dryuf\textual;


class EmailTextual extends \net\dryuf\textual\TrimRegexpTextual
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
		return "^[-a-zA-Z0-9_\\.]+@([a-zA-Z0-9_][-a-zA-Z0-9_]*\\.)+\\w+\$";
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getErrorMessage()
	{
		return $this->callerContext->getUiContext()->localize('net\dryuf\textual\EmailTextual', "E-mail (name@domain) required");
	}
};


?>
