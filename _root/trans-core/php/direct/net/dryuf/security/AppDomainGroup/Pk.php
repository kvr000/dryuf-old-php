<?php

namespace net\dryuf\security\AppDomainGroup;


/**
@\net\dryuf\meta\FieldOrder(fields = { "domain", "groupName" })
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
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setGroupName($groupName_)
	{
		$this->groupName = $groupName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getGroupName()
	{
		return $this->groupName;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "domain")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "guest", roleSet = "_denied_", roleDel = "sysmeta")
	*/
	protected			$domain;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "groupName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysmeta", roleGet = "guest", roleSet = "_denied_", roleDel = "sysmeta")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$groupName;

	/**
	*/
	function			__construct($domain = null, $groupName = null)
	{
		parent::__construct();
		$this->domain = $domain;
		$this->groupName = $groupName;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->domain) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->domain)))*37+(is_null($this->groupName) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->groupName));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\security\AppDomainGroup\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->domain) ? is_null($s->domain) : ($this->domain === $s->domain)) && (is_null($this->groupName) ? is_null($s->groupName) : ($this->groupName === $s->groupName));
	}
};


?>
