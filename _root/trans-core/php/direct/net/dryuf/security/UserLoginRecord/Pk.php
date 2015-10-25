<?php

namespace net\dryuf\security\UserLoginRecord;


/**
@\net\dryuf\meta\FieldOrder(fields = { "userId", "loginTime" })
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "admin", roleDel = "admin")
@\javax\persistence\Embeddable
*/
class Pk extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUserId($userId_)
	{
		$this->userId = $userId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getUserId()
	{
		return $this->userId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLoginTime($loginTime_)
	{
		$this->loginTime = $loginTime_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getLoginTime()
	{
		return $this->loginTime;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "userId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "UserAccount.read", roleSet = "_denied_", roleDel = "admin")
	*/
	protected			$userId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "loginTime")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "_denied_", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$loginTime;

	/**
	*/
	function			__construct($userId = null, $loginTime = null)
	{
		parent::__construct();
		$this->userId = $userId;
		$this->loginTime = $loginTime;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->userId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->userId)))*37+(is_null($this->loginTime) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->loginTime));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\security\UserLoginRecord\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->userId) ? is_null($s->userId) : ($this->userId === $s->userId)) && (is_null($this->loginTime) ? is_null($s->loginTime) : ($this->loginTime === $s->loginTime));
	}
};


?>
