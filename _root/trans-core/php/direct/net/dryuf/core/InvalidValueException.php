<?php

namespace net\dryuf\core;


class InvalidValueException extends \net\dryuf\core\RuntimeException
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($value, $msg)
	{
		parent::__construct($msg.": ".$value);
	}

	/**
	*/
	function			__construct($value, $cause)
	{
		parent::__construct("invalid value: ".$value, $cause);
	}

	/**
	*/
	function			__construct($value, $msg, $cause)
	{
		parent::__construct($msg.": ".$value, $cause);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$value;
};


?>
