<?php

namespace net\dryuf\security\mvp;


class CommonRegisterActivatePresenter extends \net\dryuf\security\mvp\RegisterActivatePresenter
{
	/**
	*/
	function			__construct($parentPresenter, $options)
	{
		parent::__construct($parentPresenter, $options);
		$appContainer = $this->getCallerContext()->getAppContainer();
		$this->userAccountDao = $appContainer->getBeanTyped("userAccountDao", 'net\dryuf\security\dao\UserAccountDao');
		$this->userAccountBo = $appContainer->getBeanTyped("userAccountBo", 'net\dryuf\security\bo\UserAccountBo');
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			doActivate($username, $activationCode)
	{
		if (is_null(($userAccount = $this->userAccountDao->loadByUsername($username))))
			return \net\dryuf\security\bo\UserAccountBo::ERR_UnknownAccount;
		if (is_null(($code = $this->userAccountBo->getActivityCode($userAccount->getUserId())))) {
			return \net\dryuf\security\bo\UserAccountBo::ERR_BadActivationCode;
		}
		if (!($code === $activationCode))
			return \net\dryuf\security\bo\UserAccountBo::ERR_BadActivationCode;
		if (!$this->userAccountDao->activateUser($userAccount->getUserId(), intval(microtime(true)*1000)))
			throw new \net\dryuf\core\RuntimeException("failed to activate user");
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
};


?>
