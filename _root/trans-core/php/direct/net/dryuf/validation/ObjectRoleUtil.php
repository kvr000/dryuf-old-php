<?php

namespace net\dryuf\validation;


class ObjectRoleUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public static function		checkMandatory($errors, $role, $fieldDef)
	{
		if ($fieldDef->getMandatory()) {
			$errors->rejectField($fieldDef->getName(), $role->getUiContext()->localize('net\dryuf\validation\ObjectRoleUtil', "Field is mandatory"));
			return false;
		}
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public static function		setWithRole($errors, $obj, $role, $values)
	{
		return \net\dryuf\validation\ObjectRoleUtil::setWithRoleInternal($errors, $obj, $role, $values, \net\dryuf\app\ClassMetaManager::openCached($role->getAppContainer(), get_class($obj), null));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public static function		newWithRole($errors, $obj, $role, $values)
	{
		return \net\dryuf\validation\ObjectRoleUtil::newWithRoleInternal($errors, $obj, $role, $values, \net\dryuf\app\ClassMetaManager::openCached($role->getAppContainer(), get_class($obj), null));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public static function		getWithRole($obj, $role)
	{
		return \net\dryuf\validation\ObjectRoleUtil::getWithRoleInternal($obj, $role, \net\dryuf\app\ClassMetaManager::openCached($role->getAppContainer(), get_class($obj), null));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected static function	getScalarInternal($obj, $role, $fieldDef)
	{
		return $fieldDef->getValue($obj);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected static function	setScalarInternal($errors, $obj, $role, $fieldDef, $value)
	{
		$textualClass = $fieldDef->getTextual();
		if (!is_null($textualClass)) {
			$newValue = \net\dryuf\core\ConversionUtil::convertToClass($fieldDef->getType(), $value);
			if (is_null($newValue)) {
				if (!\net\dryuf\validation\ObjectRoleUtil::checkMandatory($errors, $role, $fieldDef))
					return false;
			}
			else {
				$textual = \net\dryuf\textual\TextualManager::createTextualUnsafe($textualClass, $role);
				try {
					$err = $textual->validate($newValue);
					if (!is_null($err)) {
						$errors->rejectField($fieldDef->getName(), $err);
						return false;
					}
				}
				catch (\net\dryuf\core\Exception $ex) {
					throw new \net\dryuf\core\RuntimeException("Failed to validate field ".$fieldDef->getName().": ".strval($ex), $ex);
				}
			}
			$fieldDef->setValue($obj, $newValue);
		}
		elseif (\net\dryuf\core\ConversionUtil::isScalarClass($fieldDef->getType())) {
			$fieldDef->setValue($obj, \net\dryuf\core\ConversionUtil::convertToClass($fieldDef->getType(), $value));
		}
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected static function	getOrCreateEmbeddedInternal($obj, $fieldDef)
	{
		$value = $fieldDef->getValue($obj);
		if (is_null($value)) {
			$value = $fieldDef->getEmbedded()->instantiate();
			$fieldDef->setValue($obj, $value);
		}
		return $value;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected static function	getWithRoleInternal($obj, $role, $classMeta)
	{
		$result = new \net\dryuf\util\php\StringNativeHashMap();
		foreach ($classMeta->getFields() as $fieldDef) {
			$roles = $fieldDef->getRoles();
			if (!$role->checkRole($roles->roleGet()))
				continue;
			try {
				switch ($fieldDef->getAssocType()) {
				case \net\dryuf\app\FieldDef::AST_None:
				case \net\dryuf\app\FieldDef::AST_Reference:
				case \net\dryuf\app\FieldDef::AST_Compos:
					if (!is_null(($embeddedMeta = $fieldDef->getEmbedded()))) {
						$value = $fieldDef->getValue($obj);
						if (!is_null($value))
							$value = \net\dryuf\validation\ObjectRoleUtil::getWithRoleInternal($value, $role, $embeddedMeta);
					}
					else {
						$value = \net\dryuf\validation\ObjectRoleUtil::getScalarInternal($obj, $role, $fieldDef);
					}
					break;

				case \net\dryuf\app\FieldDef::AST_Children:
					{
						$orig = $fieldDef->getValue($obj);
						$converted = new \net\dryuf\util\LinkedList();
						foreach ($orig as $element)
							$converted->add(\net\dryuf\validation\ObjectRoleUtil::getWithRole($element, $role));
						$value = $converted;
					}
					break;

				default:
					throw new \net\dryuf\core\RuntimeException(("Unknown association type: ".$fieldDef->getAssocType()));
				}
				$result->put($fieldDef->getName(), $value);
			}
			catch (\net\dryuf\core\Exception $ex) {
				throw new \net\dryuf\core\RuntimeException("Failed to get ".$fieldDef->getName().": ".strval($ex), $ex);
			}
		}
		return $result;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected static function	setWithRoleInternal($errors, $obj, $role, $values, $classMeta)
	{
		foreach ($values->entrySet() as $entry) {
			$fieldDef = $classMeta->getField($entry->getKey());
			try {
				$roles = $fieldDef->getRoles();
				if (!is_null(($embeddedMeta = $fieldDef->getEmbedded()))) {
					try {
						$inputMap = $entry->getValue();
					}
					catch (\java\lang\ClassCastException $ex) {
						throw new \net\dryuf\core\RuntimeException("Failed to cast field ".$fieldDef->getName()." to Map: ".strval($ex));
					}
					$errors->pushNestedPath($fieldDef->getName());
					\net\dryuf\validation\ObjectRoleUtil::setWithRoleInternal($errors, \net\dryuf\validation\ObjectRoleUtil::getOrCreateEmbeddedInternal($obj, $fieldDef), $role, $inputMap, $embeddedMeta);
					$errors->popNestedPath();
				}
				else {
					if (!$role->checkRole($roles->roleSet()))
						throw new \net\dryuf\core\SecurityException("Denied to set ".get_class($obj).".".$fieldDef->getName());
					\net\dryuf\validation\ObjectRoleUtil::setScalarInternal($errors, $obj, $role, $fieldDef, $entry->getValue());
				}
			}
			catch (\net\dryuf\core\Exception $ex) {
				throw new \net\dryuf\core\RuntimeException("Failed to set ".$fieldDef->getName().": ".strval($ex), $ex);
			}
		}
		return !$errors->hasErrors();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected static function	newWithRoleInternal($errors, $obj, $role, $values, $classMeta)
	{
		foreach ($values->entrySet() as $entry) {
			$fieldDef = $classMeta->getField($entry->getKey());
			try {
				$roles = $fieldDef->getRoles();
				if (!is_null(($embeddedMeta = $fieldDef->getEmbedded()))) {
					try {
						$inputMap = $entry->getValue();
					}
					catch (\java\lang\ClassCastException $ex) {
						throw new \net\dryuf\core\RuntimeException("Failed to cast field ".$fieldDef->getName()." to Map: ".strval($ex));
					}
					$errors->pushNestedPath($fieldDef->getName());
					\net\dryuf\validation\ObjectRoleUtil::newWithRoleInternal($errors, \net\dryuf\validation\ObjectRoleUtil::getOrCreateEmbeddedInternal($obj, $fieldDef), $role, $inputMap, $embeddedMeta);
					$errors->popNestedPath();
				}
				else {
					if (!$role->checkRole($roles->roleNew()))
						throw new \net\dryuf\core\SecurityException("Denied to set ".get_class($obj).".".$fieldDef->getName());
					\net\dryuf\validation\ObjectRoleUtil::setScalarInternal($errors, $obj, $role, $fieldDef, $entry->getValue());
				}
			}
			catch (\net\dryuf\core\Exception $ex) {
				throw new \net\dryuf\core\RuntimeException("Failed to set ".$fieldDef->getName().": ".strval($ex), $ex);
			}
		}
		return !$errors->hasErrors();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\Class<java\lang\Object>, java\lang\Class<java\lang\Object>>')
	*/
	static				$primitiveMap;

	public static function		_initManualStatic()
	{
		self::$primitiveMap = \net\dryuf\util\MapUtil::createHashMap('boolean', 'java\lang\Boolean', 'byte', 'integer', 'short', 'integer', 'int', 'integer', 'long', 'integer');
	}

};

\net\dryuf\validation\ObjectRoleUtil::_initManualStatic();


?>
