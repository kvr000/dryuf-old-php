<?php

namespace net\dryuf\security\form;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "change", isStatic = false, formActioner = ".performChange", roleAction = "guest")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'void', pkField = "", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "oldPassword", "password", "password2" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "ChangePasswordForm")
*/
class ChangePasswordForm extends \net\dryuf\core\Object
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
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "oldPassword")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\PasswordTextual')
	@\net\dryuf\textual\DisplayUse(display = "password(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$oldPassword;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "password")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\PasswordTextual')
	@\net\dryuf\textual\DisplayUse(display = "password(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$password;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "password2")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\PasswordTextual')
	@\net\dryuf\textual\DisplayUse(display = "password(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "guest")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$password2;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setOldPassword($oldPassword_)
	{
		$this->oldPassword = $oldPassword_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getOldPassword()
	{
		return $this->oldPassword;
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
	public function			setPassword2($password2_)
	{
		$this->password2 = $password2_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPassword2()
	{
		return $this->password2;
	}
};


?>
