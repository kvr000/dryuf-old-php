<?php

namespace net\dryuf\datagrid;


class DataPresenter_ModeInfo extends \net\dryuf\datagrid\DataPresenter_ModeSingle
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
	public function			processCommon()
	{
		$this->getDataPresenter()->setRenderingInfo();
		return true;
	}
};


?>
