<?php

namespace net\dryuf\datagrid;


abstract class DataPresenter_SubMode extends \net\dryuf\mvp\ChildPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->dataProvider = $this->getDataPresenter()->getDataProvider();
		$this->classMeta = $this->getDataPresenter()->getClassMeta();
		$this->mode = $this->getDataPresenter()->getMode();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\datagrid\DataPresenter<java\lang\Object>')
	*/
	public function			getDataPresenter()
	{
		return $this->getParentPresenter();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$mode;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\dao\DynamicDao<java\lang\Object, java\lang\Object>')
	*/
	protected			$dataProvider;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	protected			$classMeta;
};


?>
