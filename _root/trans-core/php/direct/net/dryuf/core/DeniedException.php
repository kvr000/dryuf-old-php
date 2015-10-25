<?php

namespace net\dryuf\core;


class DeniedException extends \net\dryuf\core\RuntimeException
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($clazz, $operation)
	{
		parent::__construct("not allowed to run ".$clazz.".".$operation);
	}
};


?>
