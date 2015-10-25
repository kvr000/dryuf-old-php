<?php

namespace net\dryuf\datagrid;


class InfoRenderer extends \net\dryuf\datagrid\SingleRenderer
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
	public function			prepareData(\net\dryuf\datagrid\DataPresenter $presenter, $object, $carrier)
	{
		$this->prepareLeadChild($presenter);
		$this->prepareObject($presenter, $object, $carrier);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			renderData(\net\dryuf\datagrid\DataPresenter $presenter, $object, $carrier)
	{
		$this->renderInfo($presenter, $object, $carrier);
	}
};


?>
