<?php

namespace net\dryuf\dao;


class DaoConstraintException extends \net\dryuf\dao\DaoAccessException
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($cause)
	{
		parent::__construct($cause);
	}
};


?>
