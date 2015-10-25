<?php

namespace net\dryuf\datagrid;


class DataPresenter_ModeObject extends \net\dryuf\datagrid\DataPresenter_SubMode
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processFinal()
	{
		return $this->getDataPresenter()->processObjectMode("info");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processMore($element)
	{
		return $this->getDataPresenter()->processObjectAction($element);
	}
};


?>
