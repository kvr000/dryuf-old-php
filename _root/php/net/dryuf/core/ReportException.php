<?php

namespace net\dryuf\core;


class ReportException extends \net\dryuf\core\RuntimeException
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($msg, $cause = null)
	{
		parent::__construct($msg, $cause);
	}
};


?>
