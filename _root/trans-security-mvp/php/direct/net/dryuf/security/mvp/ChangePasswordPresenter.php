<?php

namespace net\dryuf\security\mvp;


abstract class ChangePasswordPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\form\ChangePasswordForm')
	*/
	public function			createBackingObject()
	{
		$this->setSelectFieldName("oldPassword");
		return new \net\dryuf\security\form\ChangePasswordForm();
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
		return \net\dryuf\mvp\Presenter::createSubPresenter('net\dryuf\security\mvp\ChangePasswordOkPresenter', $this->parentPresenter, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$this->getRootPresenter()->setActiveField(0, "oldPassword");
		parent::prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			retrieve($errors, $action)
	{
		if (!parent::retrieve($errors, $action))
			return false;
		$changePasswordForm = $this->getBackingObject();
		if (!($changePasswordForm->getPassword2() === $changePasswordForm->getPassword())) {
			$errors->put("password2", $this->localize('net\dryuf\security\mvp\ChangePasswordPresenter', "Passwords do not match"));
		}
		return $errors->isEmpty();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performChange($action)
	{
		switch (($err = $this->doChange())) {
		case \net\dryuf\security\bo\UserAccountBo::ERR_Ok:
			return $this->commitOk();

		case \net\dryuf\security\bo\UserAccountBo::ERR_UnknownAccount:
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, $this->formClassName, "User does not exist");
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_WrongPassword:
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, $this->formClassName, "Wrong old password");
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
	public abstract function	doChange();
};


?>
