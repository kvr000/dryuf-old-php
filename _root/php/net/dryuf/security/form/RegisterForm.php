<?php

namespace net\dryuf\security\form;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "register", isStatic = false, formActioner = ".performRegister", roleAction = "guest")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'void', pkField = "", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "username", "email", "email2", "password", "password2", "firstName", "lastName", "phone", "captcha" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "RegisterForm")
*/
class RegisterForm extends \net\dryuf\core\Object
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
	@\javax\persistence\Column(name = "username")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$username;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "email")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\EmailTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$email;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "email2")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\EmailTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$email2;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "password")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\PasswordTextual')
	@\net\dryuf\textual\DisplayUse(display = "password(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$password;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "password2")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\PasswordTextual')
	@\net\dryuf\textual\DisplayUse(display = "password(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$password2;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "firstName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$firstName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "lastName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$lastName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "phone")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\PhoneTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = false)
	*/
	protected			$phone;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "captcha")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\CaptchaTextual')
	@\net\dryuf\textual\DisplayUse(display = "captcha(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "guest", roleGet = "guest", roleSet = "guest", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$captcha;

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
	public function			setEmail2($email2_)
	{
		$this->email2 = $email2_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getEmail2()
	{
		return $this->email2;
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
	public function			setCaptcha($captcha_)
	{
		$this->captcha = $captcha_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getCaptcha()
	{
		return $this->captcha;
	}
};


?>
