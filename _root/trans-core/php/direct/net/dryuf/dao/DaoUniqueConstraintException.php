<?php

namespace net\dryuf\dao;


class DaoUniqueConstraintException extends \net\dryuf\dao\DaoConstraintException
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
