<?php

namespace net\dryuf\security\mvp;


abstract class ForgotPasswordPresenter extends \net\dryuf\mvp\BeanFormPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\form\ForgotPasswordForm')
	*/
	public function			createBackingObject()
	{
		$this->setSelectFieldName("username");
		return new \net\dryuf\security\form\ForgotPasswordForm();
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
		return \net\dryuf\mvp\Presenter::createSubPresenter('net\dryuf\security\mvp\ForgotPasswordOkPresenter', $this->parentPresenter, \net\dryuf\core\Options::$NONE);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		$this->getRootPresenter()->setActiveField(0, "username");
		parent::prepare();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			performSend($action)
	{
		switch (($err = $this->doSend())) {
		case 0:
			return $this->commitOk();

		case 1:
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, $this->formClassName, "User does not exist");
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
	public abstract function	doSend();
};


?>
