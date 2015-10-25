<?php

namespace net\dryuf\security;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "new", isStatic = true, guiDef = "target=this", roleAction = "admin"),
	@\net\dryuf\meta\ActionDef(name = "remove", isStatic = false, guiDef = "target=this", roleAction = "admin"),
	@\net\dryuf\meta\ActionDef(name = "edit", isStatic = false, guiDef = "target=this mode=edit", roleAction = "UserAccount.write"),
	@\net\dryuf\meta\ActionDef(name = "changeSysPassword", isStatic = true, formName = "net.dryuf.security.form.ChangePasswordForm", roleAction = "user"),
	@\net\dryuf\meta\ActionDef(name = "viewLoginHistory", isStatic = false, guiDef = "target=dynamic relation=loginRecords", roleAction = "UserAccount.read")
})
@\net\dryuf\meta\RelationDefs(relations = {
	@\net\dryuf\meta\RelationDef(name = "loginRecords", targetClass = "net.dryuf.security.UserLoginRecord")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'integer', pkField = "userId", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "userId", "created", "username", "password", "email", "openId", "firstName", "lastName", "phone", "activated", "activityStamp" })
@\net\dryuf\dao\RoleProcessorUse(roleProcessor = 'net\dryuf\security\dao\UserAccountRoleProcessor')
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Ref"),
	@\net\dryuf\meta\ViewInfo(name = "Default"),
	@\net\dryuf\meta\ViewInfo(name = "Admin")
})
@\net\dryuf\meta\SuggestDef(fields = { "username" })
@\net\dryuf\meta\RefFieldsDef(fields = { "username", "email" })
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "UserAccount.update", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "UserAccount")
*/
class UserAccount extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "userId")
	@\javax\persistence\GeneratedValue(strategy = \javax\persistence\GenerationType::AUTO)
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "UserAccount.read", roleSet = "extreme", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$userId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "created")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "extreme", roleGet = "UserAccount.read", roleSet = "extreme", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$created = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "username")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$username;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "password")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\PasswordTextual')
	@\net\dryuf\textual\DisplayUse(display = "password(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "admin", roleSet = "admin", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$password;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "email")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\EmailTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "UserAccount.update", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$email;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "openId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "UserAccount.update", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$openId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "firstName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "UserAccount.update", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$firstName = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "lastName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "UserAccount.update", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$lastName = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "phone")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\PhoneTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "UserAccount.update", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$phone;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	@\javax\persistence\Column(name = "activated")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\BoolSwitchTextual')
	@\net\dryuf\textual\DisplayUse(display = "checkbox()")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "UserAccount.update", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$activated = false;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\persistence\Column(name = "activityStamp")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\DateTimeTextual')
	@\net\dryuf\textual\DisplayUse(display = "datetime(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "UserAccount.read", roleSet = "UserAccount.update", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$activityStamp = 0;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getPk()
	{
		return $this->userId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($userId_)
	{
		$this->userId = $userId_;
	}

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
	public function			setCreated($created_)
	{
		$this->created = $created_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getCreated()
	{
		return $this->created;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setUsername($username_)
	{
		$this->username = $username_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getUsername()
	{
		return $this->username;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPassword($password_)
	{
		$this->password = $password_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPassword()
	{
		return $this->password;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setEmail($email_)
	{
		$this->email = $email_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getEmail()
	{
		return $this->email;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setOpenId($openId_)
	{
		$this->openId = $openId_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getOpenId()
	{
		return $this->openId;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setFirstName($firstName_)
	{
		$this->firstName = $firstName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getFirstName()
	{
		return $this->firstName;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setLastName($lastName_)
	{
		$this->lastName = $lastName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getLastName()
	{
		return $this->lastName;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPhone($phone_)
	{
		$this->phone = $phone_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPhone()
	{
		return $this->phone;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setActivated($activated_)
	{
		$this->activated = $activated_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Boolean')
	*/
	public function			getActivated()
	{
		return $this->activated;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setActivityStamp($activityStamp_)
	{
		$this->activityStamp = $activityStamp_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	*/
	public function			getActivityStamp()
	{
		return $this->activityStamp;
	}
};


?>
