<?php

namespace net\dryuf\mvp;


abstract class MappedFormPresenter extends \net\dryuf\mvp\DynamicFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatFormPrefix($formClazz)
	{
		return str_replace(".", "_", $formClazz)."__";
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		setBackingObject($backingObject)
	{
		$this->backingObject = $backingObject;
		$this->formClassName = get_class($this);
		$this->formWebPrefix = \net\dryuf\mvp\MappedFormPresenter::formatFormPrefix($this->formClassName);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected function		createBackingObject()
	{
		return new \net\dryuf\util\php\StringNativeHashMap();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		$this->setBackingObject($this->createBackingObject());
		return parent::processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	public function			getActionDefs()
	{
		return \net\dryuf\util\Collections::singletonList((new \net\dryuf\app\ActionDefImpl())->setName("submit")->setRoleAction("")->setFormActioner(".performSubmit"));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performSubmit($actionDef)
	{
		throw new \net\dryuf\core\IllegalStateException("default performSubmit not implemented");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			needBackingObject()
	{
		if (is_null($this->backingObject))
			throw new \net\dryuf\core\NullPointerException("backingObject was not set");
		return $this->backingObject;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		setBackingValue($fieldDef, $value)
	{
		$this->backingObject->put($fieldDef->getName(), $value);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected function		getBackingValue($fieldDef)
	{
		return $this->backingObject->get($fieldDef->getName());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	protected			$backingObject;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	public function			getBackingObject()
	{
		return $this->backingObject;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ActionDef[]')
	*/
	protected			$backingActions;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ActionDef[]')
	*/
	public function			getBackingActions()
	{
		return $this->backingActions;
	}
};


?>
