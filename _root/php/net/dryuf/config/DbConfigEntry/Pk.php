<?php

namespace net\dryuf\config\DbConfigEntry;


/**
@\net\dryuf\meta\FieldOrder(fields = { "section", "configKey" })
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
	public function			setSection($section_)
	{
		$this->section = $section_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\DbConfigSection\Pk')
	*/
	public function			getSection()
	{
		return $this->section;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setConfigKey($configKey_)
	{
		$this->configKey = $configKey_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getConfigKey()
	{
		return $this->configKey;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\DbConfigSection\Pk')
	@\net\dryuf\meta\Mandatory(mandatory = true)
	@\javax\persistence\Column(name = "section")
	@\net\dryuf\meta\FieldRoles(roleNew = "_denied_", roleGet = "sysconf", roleSet = "_denied_", roleDel = "sysconf")
	@\javax\persistence\Embedded
	*/
	protected			$section;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "configKey")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "extreme", roleDel = "sysconf")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$configKey;

	/**
	*/
	function			__construct($section = null, $configKey = null)
	{
		parent::__construct();
		$this->section = $section;
		$this->configKey = $configKey;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return ((0)*37+(is_null($this->section) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->section)))*37+(is_null($this->configKey) ? 0 : \net\dryuf\core\Dryuf::hashCodeObject($this->configKey));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\config\DbConfigEntry\Pk))
			return false;
		$s = $o;
		return true && (is_null($this->section) ? is_null($s->section) : \net\dryuf\core\Dryuf::equalObjects($this->section, $s->section)) && (is_null($this->configKey) ? is_null($s->configKey) : ($this->configKey === $s->configKey));
	}
};


?>
