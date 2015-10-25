<?php

namespace net\dryuf\datagrid;


class DbDataPresenter extends \net\dryuf\datagrid\DataPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			init()
	{
		parent::init();
		$this->setDataProvider($this->getCallerContext()->getBean($this->getDataClassName()."-dao"));
		return $this;
	}
};


?>
