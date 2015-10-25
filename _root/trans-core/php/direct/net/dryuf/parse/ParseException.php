<?php

namespace net\dryuf\parse;


class ParseException extends \net\dryuf\core\RuntimeException
{
	/**
	*/
	function			__construct($message, $cause = null)
	{
		parent::__construct($message, $cause);
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 0;
};


?>
