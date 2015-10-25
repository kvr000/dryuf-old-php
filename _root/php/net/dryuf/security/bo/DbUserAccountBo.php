<?php

namespace net\dryuf\security\bo;


class DbUserAccountBo extends \net\dryuf\security\bo\AbstractUserAccountBo
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\UserAccountDao')
	*/
	public function			getDaoUserAccount()
	{
		return $this->userAccountDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formatError($uiContext, $error)
	{
		switch ($error) {
		case \net\dryuf\security\bo\UserAccountBo::ERR_Ok:
			return null;

		case \net\dryuf\security\bo\UserAccountBo::ERR_UnknownAccount:
			$code = "User unknown";
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_WrongPassword:
			$code = "Wrong password";
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_AccountLocked:
			$code = "Account locked";
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_AccountExpired:
			$code = "Account expired";
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_AccountUnactivated:
			$code = "Account unactivated";
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_UserExists:
			$code = "User exists";
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_EmailExists:
			$code = "Email exists";
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_OpenIdExists:
			$code = "Open ID exists";
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_UniqueConstraint:
			$code = "Unique constraint violation";
			break;

		case \net\dryuf\security\bo\UserAccountBo::ERR_BadActivationCode:
			$code = "Bad activation code";
			break;

		default:
			return $uiContext->localizeArgs('net\dryuf\security\bo\UserAccountBo', "Unknown error: {0}", 
				array(
					$error
				));
		}
		return $uiContext->localize('net\dryuf\security\bo\UserAccountBo', $code);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainDef')
	*/
	public function			getAppDomainDef()
	{
		return $this->appDomainDefDao->loadByPk($this->appDomainId);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			storeLoginRecord($userAccount, $sessionId, $sourceIp)
	{
		$time = $this->timeBo->currentTimeMillis();
		$userLoginRecord = new \net\dryuf\security\UserLoginRecord();
		$userLoginRecord->setUserId($userAccount->getUserId());
		$userLoginRecord->setLoginTime($time);
		$userLoginRecord->setLoginAddress($sourceIp);
		$userLoginRecord->setAccessTime($time);
		$userLoginRecord->setSessionId($sessionId);
		$userLoginRecord->setTargetApp($this->appName);
		$this->userLoginRecordDao->insert($userLoginRecord);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			setUserPassword($userAccount, $newPassword)
	{
		return $this->userAccountDao->runTransactionedNewSafe(
			function () use ($userAccount, $newPassword) {
				if (!$this->userAccountDao->setPassword($userAccount->getUserId(), $this->encodePassword($userAccount->getUsername(), null, $newPassword), intval(microtime(true)*1000)))
					return 1;
				return 0;
			}
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getActivityCode($userId)
	{
		$userAccount = $this->userAccountDao->loadByPk($userId);
		if (is_null($userAccount))
			return null;
		return $this->digestString($userAccount->getUsername().$userAccount->getEmail().$userAccount->getActivityStamp());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			digestString($input)
	{
		return hash("sha256", $input, false);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			updateActivity($userId)
	{
		$this->userAccountDao->updateActivity($userId, intval(microtime(true)*1000));
		return $this->getActivityCode($userId);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			activateUser($username)
	{
		return $this->userAccountDao->runTransactionedNewSafe(
			function () use ($username) {
				if (is_null(($userAccount = $this->userAccountDao->loadByUsername($username))))
					return \net\dryuf\security\bo\UserAccountBo::ERR_UnknownAccount;
				return $this->userAccountDao->activateUser($userAccount->getUserId(), $this->timeBo->currentTimeMillis()) ? \net\dryuf\security\bo\UserAccountBo::ERR_Ok : \net\dryuf\security\bo\UserAccountBo::ERR_UnknownAccount;
			}
		);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccount')
	*/
	public function			load($userId)
	{
		return $this->userAccountDao->loadByPk($userId);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			loadUsername($userId)
	{
		$userAccount = $this->load($userId);
		return !is_null($userAccount) ? $userAccount->getUsername() : null;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccount')
	*/
	public function			loadByUsername($username)
	{
		return $this->userAccountDao->loadByUsername($username);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<java\lang\String>')
	*/
	public function			listUserDomainRoles($userId)
	{
		$roles = new \net\dryuf\util\php\StringNativeHashSet($this->userAccountDomainRoleDao->listRolesForUserDomain($userId, $this->appDomainId));
		$roles->addAll($this->userAccountDomainGroupDao->listGroupRolesForUserDomain($userId, $this->appDomainId));
		return $roles;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainDef')
	*/
	public function			loadDomainByAlias($alias)
	{
		return $this->appDomainDefDao->loadByPk($this->appDomainId);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addUserDomainRoles($userAccount, $domainDef, $roles)
	{
		$userAccountDomain = new \net\dryuf\security\UserAccountDomain();
		$userAccountDomain->setUserId($userAccount->getUserId());
		$userAccountDomain->setDomain($domainDef->getDomain());
		$this->userAccountDomainDao->update($userAccountDomain);
		foreach ($roles as $roleName) {
			$userAccountDomainRole = new \net\dryuf\security\UserAccountDomainRole();
			$userAccountDomainRole->setDomain($userAccountDomain->getPk());
			$userAccountDomainRole->setRoleName($roleName);
			$this->userAccountDomainRoleDao->update($userAccountDomainRole);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			createUser($userAccount, $plainPassword)
	{
		$userAccount->setPassword($this->encodePassword($userAccount->getUsername(), $this->genSalt(), $plainPassword));
		$userAccount->setActivityStamp(intval(microtime(true)*1000));
		$this->userAccountDao->runTransactionedNewSafe(
			function () use ($userAccount) {
				$this->userAccountDao->insert($userAccount);
				$this->userAccountDomainRoleDao->initUserWithDefaultRoles($userAccount->getUserId(), $this->appDomainId);
				$this->userAccountDomainGroupDao->initUserWithDefaultGroups($userAccount->getUserId(), $this->appDomainId);
				return $userAccount;
			}
		);
		return \net\dryuf\security\bo\UserAccountBo::ERR_Ok;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\UserAccountDao')
	@\javax\inject\Inject
	*/
	protected			$userAccountDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\UserLoginRecordDao')
	@\javax\inject\Inject
	*/
	protected			$userLoginRecordDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\AppDomainDefDao')
	@\javax\inject\Inject
	*/
	protected			$appDomainDefDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\UserAccountDomainDao')
	@\javax\inject\Inject
	*/
	protected			$userAccountDomainDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\UserAccountDomainRoleDao')
	@\javax\inject\Inject
	*/
	protected			$userAccountDomainRoleDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\UserAccountDomainGroupDao')
	@\javax\inject\Inject
	*/
	protected			$userAccountDomainGroupDao;
};


?>
