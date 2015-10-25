<?php

namespace org\springframework\dao;


class DataAccessException extends \net\dryuf\core\RuntimeException
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($message, $cause)
	{
		parent::__construct($message, $cause);
	}
};


?>
