<?php

namespace net\dryuf\validation;


interface DataValidationErrors
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	function			listFieldsErrors();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getFieldError($fieldName);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	*/
	function			listGlobalErrors();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			rejectField($fieldName, $message);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			rejectGlobal($message);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			pushNestedPath($path);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			popNestedPath();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			hasErrors();
};


?>
