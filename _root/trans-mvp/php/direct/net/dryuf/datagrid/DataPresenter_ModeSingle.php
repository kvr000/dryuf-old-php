<?php

namespace net\dryuf\datagrid;


class DataPresenter_ModeSingle extends \net\dryuf\datagrid\DataPresenter_SubMode
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$this->currentObject = $this->getDataPresenter()->getCurrentObject();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public				$currentObject;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			getCurrentObject()
	{
		return $this->currentObject;
	}
};


?>
