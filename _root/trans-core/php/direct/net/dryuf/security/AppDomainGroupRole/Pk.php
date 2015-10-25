<?php

namespace net\dryuf\security\AppDomainGroupRole;


/**
@\net\dryuf\meta\FieldOrder(fields = { "domainGroup", "roleName" })
@\net\dryuf\meta\FieldRoles(roleNew = "sysmeta", roleGet = "guest", roleSet = "sysmeta", roleDel = "sysmeta")
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
	public function			setDomainGroup($domainGroup_)
	{
		$this->domainGroup = $domainGroup_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainGroup\Pk')
	*/
	public function			getDomainGroup()
	{
		return $this->domainGroup;
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
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainGroup\Pk')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "domainGroup")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "guest", roleSet = "_denied_", roleDel = "sysmeta")
	@\javax\persistence\Embedded
	*/
	protected			$domainGroup;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "roleName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysmeta", roleGet = "guest", roleSet = "_denied_", roleDel = "sysmeta")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$roleName;

	/**
	*/
	function			__construct($domainGroup = null, $roleName = null)
	{
		parent::__construct();
		$this->domainGroup = $domainGroup;
		$this->roleName = $roleName;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->domainGroup) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->domainGroup)))*37+(is_null($this->roleName) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->roleName));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\security\AppDomainGroupRole\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->domainGroup) ? is_null($s->domainGroup) : \net\dryuf\core\Dryuf::equalObjects($this->domainGroup, $s->domainGroup)) && (is_null($this->roleName) ? is_null($s->roleName) : ($this->roleName === $s->roleName));
	}
};


?>
