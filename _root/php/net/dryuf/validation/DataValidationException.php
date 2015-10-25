<?php

namespace net\dryuf\validation;


class DataValidationException extends \net\dryuf\core\RuntimeException
{
	/**
	*/
	function			__construct($errors)
	{
		parent::__construct();
		$this->errors = $errors;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\validation\DataValidationErrors')
	*/
	public function			getErrors()
	{
		return $this->errors;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\validation\DataValidationErrors')
	*/
	protected			$errors;

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;
};


?>
