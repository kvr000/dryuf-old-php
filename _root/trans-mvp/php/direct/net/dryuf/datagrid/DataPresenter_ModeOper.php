<?php

namespace net\dryuf\datagrid;


class DataPresenter_ModeOper extends \net\dryuf\datagrid\DataPresenter_SubMode
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
	public function			process()
	{
		return (new \net\dryuf\mvp\oper\BeanObjectOperPresenter($this, \net\dryuf\core\Options::$NONE, $this->getDataPresenter()->getDataClassName()."-oper", $this->getDataPresenter()->getOwnerHolder()))->init()->process();
	}
};


?>
