<?php

namespace net\dryuf\dao;


class DaoPrimaryKeyConstraintException extends \net\dryuf\dao\DaoUniqueConstraintException
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
