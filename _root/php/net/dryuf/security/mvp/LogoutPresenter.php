<?php

namespace net\dryuf\security\mvp;


abstract class LogoutPresenter extends \net\dryuf\mvp\StaticPagePresenter
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
		if (!$this->doLogout())
			return false;
		return parent::processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public abstract function	doLogout();
};


?>
