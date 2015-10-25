<?php

namespace net\dryuf\security\mvp;


class CommonChangePasswordPresenter extends \net\dryuf\security\mvp\ChangePasswordPresenter
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\web\AuthenticationFrontend')
	*/
	protected			$authenticationFrontend;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\UserAccountDao')
	*/
	protected			$userAccountDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\bo\UserAccountBo')
	*/
	protected			$userAccountBo;

	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$appContainer = $this->getCallerContext()->getAppContainer();
		$this->authenticationFrontend = $this->getCallerContext()->getBeanTyped("authenticationFrontend", 'net\dryuf\security\web\AuthenticationFrontend');
		$this->userAccountDao = $appContainer->getBeanTyped("userAccountDao", 'net\dryuf\security\dao\UserAccountDao');
		$this->userAccountBo = $appContainer->getBeanTyped("userAccountBo", 'net\dryuf\security\bo\UserAccountBo');
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			doChange()
	{
		$changePasswordForm = $this->getBackingObject();
		if (is_null(($userAccount = $this->userAccountDao->loadByPk($this->getCallerContext()->getUserId())))) {
			return 1;
		}
		$err = $this->authenticationFrontend->authenticateUserPassword($this->getPageContext(), $userAccount->getUsername(), $changePasswordForm->getOldPassword());
		if ($err != 0)
			return 2;
		$this->userAccountBo->setUserPassword($userAccount, $changePasswordForm->getPassword());
		return 0;
	}
};


?>
