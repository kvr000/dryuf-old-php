<?php

namespace net\dryuf\mvp;


abstract class BeanFormPresenter extends \net\dryuf\mvp\DynamicFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		setBackingObject($backingObject)
	{
		$this->backingObject = $backingObject;
		$this->formClassName = get_class($backingObject);
		$this->formWebPrefix = \net\dryuf\mvp\BeanFormPresenter::formatFormPrefix($this->formClassName);
		$this->backingMeta = \net\dryuf\app\ClassMetaManager::openCached($this->getCallerContext()->getAppContainer(), get_class($backingObject), null);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected abstract function	createBackingObject();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		$this->setBackingObject($this->createBackingObject());
		return parent::processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\app\FieldDef<java\lang\Object>>')
	*/
	public function			buildDisplayableFields()
	{
		$fields = new \net\dryuf\util\LinkedList();
		foreach ($this->backingMeta->getFields() as $fieldDef) {
			$fields->add($fieldDef);
		}
		return $fields;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	public function			getActionDefs()
	{
		if (is_null($this->backingActions))
			$this->backingActions = \net\dryuf\util\LinkedList::createFromArray($this->backingMeta->getActions());
		return $this->backingActions;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
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
		$this->backingMeta->setEntityFieldValue($this->backingObject, $fieldDef->getName(), $value);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected function		getBackingValue($fieldDef)
	{
		return $this->backingMeta->getEntityFieldValue($this->backingObject, $fieldDef->getName());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$backingObject;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getBackingObject()
	{
		return $this->backingObject;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	protected			$backingActions;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\meta\ActionDef>')
	*/
	public function			getBackingActions()
	{
		return $this->backingActions;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	protected			$backingMeta;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	public function			getBackingMeta()
	{
		return $this->backingMeta;
	}
};


?>
