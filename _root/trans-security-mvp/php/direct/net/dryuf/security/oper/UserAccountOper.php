<?php

namespace net\dryuf\security\oper;


class UserAccountOper extends \net\dryuf\oper\DaoObjectOperController
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->setDataClass('net\dryuf\security\UserAccount');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		checkDataValidity($callerContext, $data)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\security\UserAccount>')
	*/
	public function			executeStaticCreate($operContext, $ownerHolder, $data)
	{
		$this->checkDataValidity($ownerHolder->getRole(), $data);
		return parent::executeStaticCreate($operContext, $ownerHolder, $data);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\security\UserAccount>')
	*/
	public function			executeObjectUpdate($operContext, $objectHolder, $data)
	{
		$this->checkDataValidity($objectHolder->getRole(), $data);
		return parent::executeObjectUpdate($operContext, $objectHolder, $data);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	@\net\dryuf\oper\ObjectOperRules(value = "changeSysPassword", reqRole = "free", isStatic = true, isFinal = true, actionClass = 'net\dryuf\security\form\ChangePasswordForm')
	*/
	public function			changeSysPassword($presenter, $ownerHolder, $changePasswordForm)
	{
		$userAccount = $this->userAccountDao->loadByPk($presenter->getCallerContext()->getUserId());
		\net\dryuf\core\Dryuf::assertNotNull($userAccount, "userAccount cannot be null");
		if (!($changePasswordForm->getPassword() === $changePasswordForm->getPassword2())) {
			\net\dryuf\validation\DataValidatorUtil::throwValidationError($changePasswordForm, "password2", $presenter->localize('net\dryuf\security\oper\UserAccountDomainRoleOper', "Passwords do not match"));
		}
		if ($this->userAccountBo->checkUserPassword($userAccount->getUserId(), $changePasswordForm->getOldPassword()) != 0) {
			\net\dryuf\validation\DataValidatorUtil::throwValidationError($changePasswordForm, "oldPassword", $presenter->localize('net\dryuf\security\oper\UserAccountDomainRoleOper', "Old password is wrong"));
		}
		$this->userAccountBo->setUserPassword($userAccount, $changePasswordForm->getPassword());
		return new \net\dryuf\oper\ObjectOperController\SuccessContainer(true);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\UserAccountDao')
	@\javax\inject\Inject
	*/
	protected			$userAccountDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\bo\UserAccountBo')
	@\javax\inject\Inject
	*/
	protected			$userAccountBo;
};


?>
