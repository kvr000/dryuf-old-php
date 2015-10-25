<?php

namespace net\dryuf\security\mvp;


class CommonForgotPasswordPresenter extends \net\dryuf\security\mvp\ForgotPasswordPresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$appContainer = $this->getCallerContext()->getAppContainer();
		$this->userAccountDao = $appContainer->getBeanTyped("userAccountDao", 'net\dryuf\security\dao\UserAccountDao');
		$this->userAccountBo = $appContainer->getBeanTyped("userAccountBo", 'net\dryuf\security\bo\UserAccountBo');
		$this->emailSender = $appContainer->getBeanTyped("emailSender", 'net\dryuf\service\mail\EmailSender');
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			doSend()
	{
		$forgotPasswordForm = $this->getBackingObject();
		if (is_null(($userAccount = $this->userAccountDao->loadByUsername($forgotPasswordForm->getUsername())))) {
			return 1;
		}
		if (!$this->userAccountDao->updateActivity($userAccount->getUserId(), intval(microtime(true)*1000)+3600000)) {
			return 1;
		}
		if (is_null(($code = $this->userAccountBo->getActivityCode($userAccount->getUserId())))) {
			return 1;
		}
		$this->emailSender->mailUtf8($userAccount->getEmail(), $this->localize('net\dryuf\security\mvp\CommonForgotPasswordPresenter', "User Forgotten Password"), $this->localize('net\dryuf\security\mvp\CommonForgotPasswordPresenter', "You asked for changing the user password on our website. Please change it by clicking on")." ".\net\dryuf\net\util\UrlUtil::truncateToParent($this->getRootPresenter()->getFullUrl())."forgotupdatepassword/?username=".$forgotPasswordForm->getUsername()."&code=".$code, null);
		return 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\UserAccountDao')
	*/
	protected			$userAccountDao;

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
