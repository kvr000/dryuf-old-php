<?php

namespace net\dryuf\menu\WebAccessiblePage;


/**
@\net\dryuf\meta\FieldOrder(fields = { "providerName", "pageCode" })
@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "admin", roleDel = "admin")
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
	public function			setProviderName($providerName_)
	{
		$this->providerName = $providerName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getProviderName()
	{
		return $this->providerName;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPageCode($pageCode_)
	{
		$this->pageCode = $pageCode_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPageCode()
	{
		return $this->pageCode;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "providerName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "guest", roleSet = "_denied_", roleDel = "admin")
	*/
	protected			$providerName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "pageCode")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "admin", roleGet = "guest", roleSet = "_denied_", roleDel = "admin")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$pageCode;

	/**
	*/
	function			__construct($providerName = null, $pageCode = null)
	{
		parent::__construct();
		$this->providerName = $providerName;
		$this->pageCode = $pageCode;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->providerName) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->providerName)))*37+(is_null($this->pageCode) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->pageCode));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\menu\WebAccessiblePage\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->providerName) ? is_null($s->providerName) : ($this->providerName === $s->providerName)) && (is_null($this->pageCode) ? is_null($s->pageCode) : ($this->pageCode === $s->pageCode));
	}
};


?>
