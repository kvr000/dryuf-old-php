<?php

namespace net\dryuf\oper\ObjectOperController;


class ErrorContainer extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'org\springframework\validation\Errors')
	*/
	public				$errors;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public				$message;

	/**
	*/
	function			__construct($message, $errors)
	{
		parent::__construct();
		$this->errors = $errors;
	}
};


?>
