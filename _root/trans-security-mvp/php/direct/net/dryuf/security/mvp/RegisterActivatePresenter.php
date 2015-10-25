<?php

namespace net\dryuf\security\mvp;


abstract class RegisterActivatePresenter extends \net\dryuf\mvp\ChildPresenter
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
		$username = $this->getRequest()->getParam("username");
		$activationCode = $this->getRequest()->getParam("code");
		$this->error = $this->doActivate($username, $activationCode);
		return parent::processCommon();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			prepare()
	{
		parent::prepare();
		switch ($this->error) {
		case 0:
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Info, 'net\dryuf\security\mvp\RegisterActivatePresenter', "Activation successfull, you can login now");
			break;

		case 1:
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, 'net\dryuf\security\mvp\RegisterActivatePresenter', "Unknown user");
			break;

		case 6:
			$this->addMessageLocalized(\net\dryuf\mvp\Presenter::MSG_Error, 'net\dryuf\security\mvp\RegisterActivatePresenter', "Wrong activation code");
			break;

		default:
			$this->addMessage(\net\dryuf\mvp\Presenter::MSG_Error, $this->localize('net\dryuf\security\mvp\RegisterActivatePresenter', "Unknown error:")." ".$this->error."");
			break;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public abstract function	doActivate($username, $activationCode);

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$error = 0;
};


?>
