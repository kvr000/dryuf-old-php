<?php

namespace net\dryuf\textual;


abstract class DirectKeyPreTrimTextual extends \net\dryuf\textual\PreTrimTextual
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
	public function			formatKey($internal)
	{
		return strval($internal);
	}
};


?>
