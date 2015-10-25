<?php

namespace net\dryuf\security\bo;


abstract class AbstractUserAccountBo extends \net\dryuf\core\Object implements \net\dryuf\security\bo\UserAccountBo
{
	/**
	*/
	function			__construct()
	{
		$this->globalRolesNames = array( "guest", "free", "user", "admin", "sysmeta", "sysconf", "swapuser", "dataop", "devel", "extreme", "translation", "timing" );

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			encodePassword($username, $salt, $plain)
	{
		return $this->digestString($plain."{".$username."}");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			genSalt()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			genPassword()
	{
		return \net\dryuf\text\util\TextUtil::generateCode(16);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equalPassword($username, $storedPassword, $plain)
	{
		return ($storedPassword === $this->encodePassword($username, $storedPassword, $plain));
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			login($userInfo, $roles, $sessionId, $sourceIp)
	{
		if (is_null(($loaded = $this->loadByUsername($userInfo->getUsername()))))
			return \net\dryuf\security\bo\UserAccountBo::ERR_UnknownAccount;
		if (!$this->equalPassword($loaded->getUsername(), $loaded->getPassword(), $userInfo->getPassword()))
			return \net\dryuf\security\bo\UserAccountBo::ERR_WrongPassword;
		if (!$loaded->getActivated())
			return \net\dryuf\security\bo\UserAccountBo::ERR_AccountUnactivated;
		$this->storeLoginRecord($loaded, $sessionId, $sourceIp);
		$userInfo->setUserId($loaded->getUserId());
		$userInfo->setFirstName($loaded->getFirstName());
		$userInfo->setLastName($loaded->getLastName());
		foreach ($this->listUserDomainRoles($loaded->getUserId()) as $roleName) {
			$roles->add($roleName);
		}
		return \net\dryuf\security\bo\UserAccountBo::ERR_Ok;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public abstract function	storeLoginRecord($userAccount, $sessionId, $sourceIp);

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			checkUserPassword($userId, $password)
	{
		if (is_null(($userAccount = $this->load($userId))))
			return \net\dryuf\security\bo\UserAccountBo::ERR_UnknownAccount;
		if (!$this->equalPassword($userAccount->getUsername(), $userAccount->getPassword(), $password))
			return \net\dryuf\security\bo\UserAccountBo::ERR_WrongPassword;
		return \net\dryuf\security\bo\UserAccountBo::ERR_Ok;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getActivityCode($userId)
	{
		$userAccount = $this->load($userId);
		if (is_null($userAccount))
			return null;
		return $this->digestString($userAccount->getUsername().$userAccount->getEmail().$userAccount->getActivityStamp());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			digestString($input)
	{
		$md = null;
		try {
			$md = \java\security\MessageDigest::getInstance("SHA-256");
		}
		catch (\java\security\NoSuchAlgorithmException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
		return strval(\org\apache\commons\codec\binary\Hex::encodeHex($md->digest($input)));
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
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			checkRequiredRoleForRole($callerContext, $roleName)
	{
		return $callerContext->checkRole($this->addableRolesDependencies->get($roleName)) ? null : $this->addableRolesDependencies->get($roleName);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			checkRequiredRoleForGroup($callerContext, $groupName)
	{
		return $callerContext->checkRole($this->addableGroupsDependencies->get($groupName)) ? null : $this->addableGroupsDependencies->get($groupName);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			listAddableRoles($callerContext)
	{
		return \net\dryuf\util\LinkedHashSet::createFromArray(\net\dryuf\util\Collections::transform(\net\dryuf\util\Sets::filter($this->addableRolesDependencies->entrySet(), function ($entry) use ($callerContext) { return $callerContext->checkRole($entry->getValue()); }), function ($entry) { return $entry->getKey(); }));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			listAddableGroups($callerContext)
	{
		return new \net\dryuf\util\php\StringNativeHashSet();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$appDomainId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getAppDomainId()
	{
		return $this->appDomainId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setAppDomainId($appDomainId_)
	{
		$this->appDomainId = $appDomainId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$appName;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setAppName($appName_)
	{
		$this->appName = $appName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	protected			$addableRolesDependencies;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	public function			getAddableRolesDependencies()
	{
		return $this->addableRolesDependencies;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setAddableRolesDependencies($addableRolesDependencies_)
	{
		$this->addableRolesDependencies = $addableRolesDependencies_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	protected			$addableGroupsDependencies;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	public function			getAddableGroupsDependencies()
	{
		return $this->addableGroupsDependencies;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setAddableGroupsDependencies($addableGroupsDependencies_)
	{
		$this->addableGroupsDependencies = $addableGroupsDependencies_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\time\TimeBo')
	@\javax\inject\Inject
	*/
	protected			$timeBo;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String[]')
	*/
	protected			$globalRolesNames;
};


?>
