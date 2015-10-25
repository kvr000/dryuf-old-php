<?php

namespace net\dryuf\config\DbConfigSection;


/**
@\net\dryuf\meta\FieldOrder(fields = { "profileName", "sectionName" })
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
	public function			setProfileName($profileName_)
	{
		$this->profileName = $profileName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getProfileName()
	{
		return $this->profileName;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSectionName($sectionName_)
	{
		$this->sectionName = $sectionName_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSectionName()
	{
		return $this->sectionName;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "profileName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "sysconf", roleSet = "_denied_", roleDel = "sysconf")
	*/
	protected			$profileName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "sectionName")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "extreme", roleDel = "sysconf")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$sectionName;

	/**
	*/
	function			__construct($profileName = null, $sectionName = null)
	{
		parent::__construct();
		$this->profileName = $profileName;
		$this->sectionName = $sectionName;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->profileName) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->profileName)))*37+(is_null($this->sectionName) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->sectionName));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\config\DbConfigSection\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->profileName) ? is_null($s->profileName) : ($this->profileName === $s->profileName)) && (is_null($this->sectionName) ? is_null($s->sectionName) : ($this->sectionName === $s->sectionName));
	}
};


?>
