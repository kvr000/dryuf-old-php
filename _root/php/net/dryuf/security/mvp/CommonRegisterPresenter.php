<?php

namespace net\dryuf\security\mvp;


class CommonRegisterPresenter extends \net\dryuf\security\mvp\RegisterPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$appContainer = $this->getCallerContext()->getAppContainer();
		$this->userAccountBo = $appContainer->getBeanTyped("userAccountBo", 'net\dryuf\security\bo\UserAccountBo');
		$this->emailSender = $appContainer->getBeanTyped("emailSender", 'net\dryuf\service\mail\EmailSender');
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			doRegister()
	{
		$registerForm = $this->backingObject;
		$userAccount = new \net\dryuf\security\UserAccount();
		$userAccount->setUsername($registerForm->getUsername());
		$userAccount->setEmail($registerForm->getEmail());
		try {
			$this->userAccountBo->createUser($userAccount, $registerForm->getPassword());
		}
		catch (\net\dryuf\dao\DaoUniqueConstraintException $ex) {
			$this->addMessage(\net\dryuf\mvp\Presenter::MSG_Error, $this->localize('net\dryuf\security\mvp\CommonRegisterPresenter', "User with the same name already exists, please choose different name"));
			return 1;
		}
		$this->emailSender->mailUtf8($userAccount->getEmail(), $this->localize('net\dryuf\security\mvp\CommonRegisterPresenter', "User Registration"), $this->localize('net\dryuf\security\mvp\CommonRegisterPresenter', "You asked for creating the user on our website. Please activate it clicking on")." ".\net\dryuf\net\util\UrlUtil::truncateToParent($this->getRootPresenter()->getFullUrl())."registeractivate/?username=".$userAccount->getUsername()."&code=".$this->userAccountBo->getActivityCode($userAccount->getUserId()), null);
		return 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\bo\UserAccountBo')
	*/
	protected			$userAccountBo;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\mail\EmailSender')
	*/
	protected			$emailSender;
};


?>
