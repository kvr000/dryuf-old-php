<?php

namespace net\dryuf\security\AppDomainAlias;


/**
@\net\dryuf\meta\FieldOrder(fields = { "domain", "domainAlias" })
@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "sysconf", roleDel = "sysconf")
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
	public function			setDomainAlias($domainAlias_)
	{
		$this->domainAlias = $domainAlias_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDomainAlias()
	{
		return $this->domainAlias;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "domain")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "sysconf", roleSet = "_denied_", roleDel = "sysconf")
	*/
	protected			$domain;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "domainAlias")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimLineTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "_denied_", roleDel = "sysconf")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$domainAlias;

	/**
	*/
	function			__construct($domain = null, $domainAlias = null)
	{
		parent::__construct();
		$this->domain = $domain;
		$this->domainAlias = $domainAlias;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->domain) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->domain)))*37+(is_null($this->domainAlias) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->domainAlias));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\security\AppDomainAlias\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->domain) ? is_null($s->domain) : ($this->domain === $s->domain)) && (is_null($this->domainAlias) ? is_null($s->domainAlias) : ($this->domainAlias === $s->domainAlias));
	}
};


?>
