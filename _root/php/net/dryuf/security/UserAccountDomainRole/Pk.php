<?php

namespace net\dryuf\security\UserAccountDomainRole;


/**
@\net\dryuf\meta\FieldOrder(fields = { "domain", "roleName" })
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
	public function			setDomain($domain_)
	{
		$this->domain = $domain_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccountDomain\Pk')
	*/
	public function			getDomain()
	{
		return $this->domain;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRoleName($roleName_)
	{
		$this->roleName = $roleName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRoleName()
	{
		return $this->roleName;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccountDomain\Pk')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "domain")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "admin", roleSet = "_denied_", roleDel = "sysconf")
	@\javax\persistence\Embedded
	*/
	protected			$domain;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "roleName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "admin", roleSet = "_denied_", roleDel = "sysconf")
	@\net\dryuf\meta\ReferenceDef(loadAction = "loadRoleRef", listAllAction = "listAllRoleRefs", listNewAction = "listNewRoleRefs")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$roleName;

	/**
	*/
	function			__construct($domain = null, $roleName = null)
	{
		parent::__construct();
		$this->domain = $domain;
		$this->roleName = $roleName;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->domain) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->domain)))*37+(is_null($this->roleName) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->roleName));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\security\UserAccountDomainRole\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->domain) ? is_null($s->domain) : \net\dryuf\core\Dryuf::equalObjects($this->domain, $s->domain)) && (is_null($this->roleName) ? is_null($s->roleName) : ($this->roleName === $s->roleName));
	}
};


?>
