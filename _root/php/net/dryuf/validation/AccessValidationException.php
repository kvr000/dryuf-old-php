<?php

namespace net\dryuf\validation;


class AccessValidationException extends \net\dryuf\core\RuntimeException
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($message)
	{
		parent::__construct($message);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\validation\AccessValidationException')
	*/
	public static function		createObjectException($message)
	{
		return new \net\dryuf\validation\AccessValidationException($message);
	}
};


?>
