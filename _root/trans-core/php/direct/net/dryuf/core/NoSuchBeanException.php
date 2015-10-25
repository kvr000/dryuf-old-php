<?php

namespace net\dryuf\core;


class NoSuchBeanException extends \net\dryuf\core\RuntimeException
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
