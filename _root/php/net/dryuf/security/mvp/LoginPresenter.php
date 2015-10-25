<?php

namespace net\dryuf\security\mvp;


abstract class LoginPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\form\LoginForm')
	*/
	public function			createBackingObject()
	{
		$this->setSelectFieldName("username");
		return new \net\dryuf\security\form\LoginForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$this->getRootPresenter()->setActiveField(0, $this->getFormWebPrefix()."username");
		parent::prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			initData()
	{
		$loginForm = $this->needBackingObject();
		$loginForm->setRedir($this->getRequest()->getParamDefault("redir", null));
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performLogin($action)
	{
		$this->getRootPresenter()->forceSession();
		if (is_null(($err = $this->doLogin())))
			return false;
		$this->addMessage(\net\dryuf\mvp\Presenter::MSG_Error, $err);
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public abstract function	doLogin();
};


?>
