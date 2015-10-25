<?php

namespace net\dryuf\validation;


class UniqueValidationException extends \net\dryuf\core\RuntimeException
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\validation\UniqueValidationException')
	*/
	public static function		createConstraintException($callerContext, $dataClass, $constraintName, $cause)
	{
		return new \net\dryuf\validation\UniqueValidationException($callerContext, $dataClass, $constraintName, $cause);
	}

	/**
	*/
	function			__construct($callerContext, $dataClass, $constraintName, $cause)
	{
		parent::__construct($callerContext->getUiContext()->localize($dataClass, "constraint failed ".$constraintName.""), $cause);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$dataClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDataClass()
	{
		return $this->dataClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$constraintName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getConstraintName()
	{
		return $this->constraintName;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;
};


?>
