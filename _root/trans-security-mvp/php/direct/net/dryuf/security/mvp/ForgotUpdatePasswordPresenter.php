<?php

namespace net\dryuf\security\mvp;


abstract class ForgotUpdatePasswordPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\form\ForgotUpdatePasswordForm')
	*/
	public function			createBackingObject()
	{
		$this->setSelectFieldName("password");
		return new \net\dryuf\security\form\ForgotUpdatePasswordForm();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			processCommon()
	{
		if (\net\dryuf\core\Dryuf::parseInt($this->getRequest()->getParamDefault("error", "-1")) == 0) {
			return $this->createOkPresenter()->process();
		}
		return parent::processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			createOkPresenter()
	{
		return \net\dryuf\mvp\Presenter::createSubPresenter('net\dryuf\security\mvp\ForgotUpdatePasswordOkPresenter', $this->parentPresenter, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			initData()
	{
		$forgotUpdatePasswordForm = $this->getBackingObject();
		$forgotUpdatePasswordForm->setUsername($this->getRequest()->getParam("username"));
		$forgotUpdatePasswordForm->setActivityCode($this->getRequest()->getParam("code"));
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$this->getRootPresenter()->setActiveField(0, "password");
		parent::prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			retrieve($errors, $action)
	{
		if (!parent::retrieve($errors, $action))
			return false;
		$forgotUpdatePasswordForm = $this->getBackingObject();
		if (!($forgotUpdatePasswordForm->getPassword2() === $forgotUpdatePasswordForm->getPassword())) {
			$errors->put("password2", $this->localize('net\dryuf\security\mvp\ForgotUpdatePasswordPresenter', "Passwords do not match"));
		}
		return $errors->isEmpty();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performUpdate($action)
	{
		switch (($err = $this->doUpdate())) {
		case 0:
			return $this->commitOk();

		case 1:
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, $this->formClassName, "User does not exist");
			break;

		case 6:
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, $this->formClassName, "Wrong activation code");
			break;

		default:
			$this->addMessage(\net\dryuf\mvp\Presenter::MSG_Error, $this->localize($this->formClassName, "Unknown error occurred:").$err);
			break;
		}
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			commitOk()
	{
		$this->getRootPresenter()->redirect(\net\dryuf\srvui\PageUrl::createRelative("?error=0"));
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public abstract function	doUpdate();
};


?>
