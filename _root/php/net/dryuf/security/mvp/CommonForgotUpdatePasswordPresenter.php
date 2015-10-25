<?php

namespace net\dryuf\security\mvp;


class CommonForgotUpdatePasswordPresenter extends \net\dryuf\security\mvp\ForgotUpdatePasswordPresenter
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
	public function			doUpdate()
	{
		$forgotUpdatePasswordForm = $this->getBackingObject();
		if (is_null(($userInfo = $this->userAccountDao->loadByUsername($forgotUpdatePasswordForm->getUsername())))) {
			return 1;
		}
		if (is_null(($code = $this->userAccountBo->getActivityCode($userInfo->getUserId())))) {
			return 1;
		}
		if (!($code === $forgotUpdatePasswordForm->getActivityCode()))
			return 6;
		$this->userAccountBo->setUserPassword($userInfo, $forgotUpdatePasswordForm->getPassword());
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
