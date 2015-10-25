<?php

namespace net\dryuf\security;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\security\UserLoginRecord\Pk', pkField = "pk", composClazz = 'net\dryuf\security\UserAccount', composPkClazz = 'integer', composPath = "pk.userId", additionalPkFields = { "loginTime" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "accessTime", "loginAddress", "sessionId", "targetApp" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\ListOrder(order = { "pk.loginTime DESC", "pk.userId DESC" })
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "admin", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "UserLoginRecord")
*/
class UserLoginRecord extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\security\UserLoginRecord\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserLoginRecord\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "accessTime")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$accessTime;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "loginAddress")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(80,20)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$loginAddress;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "sessionId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(80,20)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$sessionId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "targetApp")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(80,20)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "extreme", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$targetApp = "";

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUserId($userId_)
	{
		$this->pk->setUserId($userId_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getUserId()
	{
		return $this->pk->getUserId();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLoginTime($loginTime_)
	{
		$this->pk->setLoginTime($loginTime_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getLoginTime()
	{
		return $this->pk->getLoginTime();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setAccessTime($accessTime_)
	{
		$this->accessTime = $accessTime_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getAccessTime()
	{
		return $this->accessTime;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLoginAddress($loginAddress_)
	{
		$this->loginAddress = $loginAddress_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLoginAddress()
	{
		return $this->loginAddress;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSessionId($sessionId_)
	{
		$this->sessionId = $sessionId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSessionId()
	{
		return $this->sessionId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setTargetApp($targetApp_)
	{
		$this->targetApp = $targetApp_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getTargetApp()
	{
		return $this->targetApp;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserLoginRecord\Pk')
	*/
	public function			getPk()
	{
		return $this->pk;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($pk_)
	{
		$this->pk = $pk_;
	}
};


?>
