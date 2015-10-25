<?php

namespace net\dryuf\validation;


abstract class DataValidation extends \net\dryuf\core\Object implements \org\springframework\validation\BindingResult
{
	/**
	*/
	function			__construct()
	{
		$this->messages = new \net\dryuf\util\php\StringNativeHashMap();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setValidatedObject($o)
	{
		$this->validatedObject = $o;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$validatedObject;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	protected			$messages;
};


?>
