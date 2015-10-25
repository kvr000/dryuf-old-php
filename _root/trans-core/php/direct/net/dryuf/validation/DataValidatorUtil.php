<?php

namespace net\dryuf\validation;


class DataValidatorUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		validateObject($role, $obj)
	{
		$validatorDef = \net\dryuf\core\Dryuf::getClassAnnotation(get_class($obj), 'net\dryuf\meta\DataValidatorDef');
		if (is_null($validatorDef))
			return;
		try {
			$validator = \net\dryuf\core\Dryuf::createClassArg0($validatorDef->validator());
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		$errors = new \net\dryuf\validation\ObjectValidationErrors($obj);
		if (!$validator->validate($role, $errors)) {
			throw new \net\dryuf\validation\DataValidationException($errors);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		validateWithNew($role, $obj, $data)
	{
		$errors = new \net\dryuf\validation\ObjectValidationErrors($obj);
		if (!\net\dryuf\validation\ObjectRoleUtil::newWithRole($errors, $obj, $role, $data)) {
			throw new \net\dryuf\validation\DataValidationException($errors);
		}
		\net\dryuf\validation\DataValidatorUtil::validateObject($role, $obj);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		validateWithSet($role, $obj, $data)
	{
		$errors = new \net\dryuf\validation\ObjectValidationErrors($obj);
		if (!\net\dryuf\validation\ObjectRoleUtil::setWithRole($errors, $obj, $role, $data)) {
			throw new \net\dryuf\validation\DataValidationException($errors);
		}
		\net\dryuf\validation\DataValidatorUtil::validateObject($role, $obj);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		throwValidationError($obj, $fieldName, $err)
	{
		$errors = new \net\dryuf\validation\ObjectValidationErrors($obj);
		$errors->rejectField($fieldName, $err);
		throw new \net\dryuf\validation\DataValidationException($errors);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public static function		throwGlobalError($obj, $err)
	{
		$errors = new \net\dryuf\validation\ObjectValidationErrors($obj);
		$errors->rejectGlobal($err);
		throw new \net\dryuf\validation\DataValidationException($errors);
	}
};


?>
