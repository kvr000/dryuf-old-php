<?php

namespace net\dryuf\validation;


class ObjectValidationErrors extends \net\dryuf\core\Object implements \net\dryuf\validation\DataValidationErrors
{
	/**
	*/
	function			__construct($obj)
	{
		$this->fieldsErrors = new \net\dryuf\util\php\StringNativeHashMap();
		$this->globalErrors = new \net\dryuf\util\LinkedList();

		parent::__construct();
		$this->obj = $obj;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	public function			listFieldsErrors()
	{
		return $this->fieldsErrors;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFieldError($fieldName)
	{
		return $this->fieldsErrors->get($fieldName);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	*/
	public function			listGlobalErrors()
	{
		return $this->globalErrors;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			rejectField($fieldName, $message)
	{
		$fieldName = $this->getFullFieldPath($fieldName);
		if (!$this->fieldsErrors->containsKey($fieldName))
			$this->fieldsErrors->put($fieldName, $message);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			rejectGlobal($message)
	{
		$this->globalErrors->add($message);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			pushNestedPath($path)
	{
		$this->path = !is_null($this->path) ? $this->path.".".$path : $path;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			popNestedPath()
	{
		$p = \net\dryuf\core\StringUtil::lastIndexOf($this->path, '.');
		if ($p < 0) {
			$this->path = null;
		}
		else {
			$this->path = strval(substr($this->path, 0, $p));
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			hasErrors()
	{
		return !$this->fieldsErrors->isEmpty() || !$this->globalErrors->isEmpty();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	private function		getFullFieldPath($fieldName)
	{
		return !is_null($this->path) ? $this->path.".".$fieldName : $fieldName;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	protected			$fieldsErrors;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	*/
	protected			$globalErrors;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$obj;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$path;
};


?>
