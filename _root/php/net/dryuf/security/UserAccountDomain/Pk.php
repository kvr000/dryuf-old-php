<?php

namespace net\dryuf\security\UserAccountDomain;


/**
@\net\dryuf\meta\FieldOrder(fields = { "userId", "domain" })
@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "admin", roleSet = "sysconf", roleDel = "sysconf")
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
	public function			setDomain($domain_)
	{
		$this->domain = $domain_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDomain()
	{
		return $this->domain;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "userId")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\NaturalLongTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "admin", roleSet = "_denied_", roleDel = "sysconf")
	*/
	protected			$userId;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\net\dryuf\meta\AssocDef(assocType = \net\dryuf\app\FieldDef::AST_Reference, target = 'net\dryuf\security\AppDomainDef')
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "admin", roleSet = "_denied_", roleDel = "sysconf")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$domain;

	/**
	*/
	function			__construct($userId = null, $domain = null)
	{
		parent::__construct();
		$this->userId = $userId;
		$this->domain = $domain;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->userId) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->userId)))*37+(is_null($this->domain) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->domain));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\security\UserAccountDomain\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->userId) ? is_null($s->userId) : ($this->userId === $s->userId)) && (is_null($this->domain) ? is_null($s->domain) : ($this->domain === $s->domain));
	}
};


?>
