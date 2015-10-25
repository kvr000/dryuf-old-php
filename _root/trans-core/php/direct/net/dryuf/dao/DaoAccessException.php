<?php

namespace net\dryuf\dao;


class DaoAccessException extends \org\springframework\dao\DataAccessException
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($cause)
	{
		parent::__construct(strval($cause), $cause);
	}
};


?>
