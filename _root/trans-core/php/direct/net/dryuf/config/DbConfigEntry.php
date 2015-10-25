<?php

namespace net\dryuf\config;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "new", isStatic = true, guiDef = "target=this", roleAction = "sysconf"),
	@\net\dryuf\meta\ActionDef(name = "edit", isStatic = false, guiDef = "target=this", roleAction = "sysconf"),
	@\net\dryuf\meta\ActionDef(name = "remove", isStatic = false, guiDef = "target=this", roleAction = "sysconf")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\config\DbConfigEntry\Pk', pkField = "pk", composClazz = 'net\dryuf\config\DbConfigSection', composPkClazz = 'net\dryuf\config\DbConfigSection\Pk', composPath = "pk.section", additionalPkFields = { "configKey" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "configValue" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\ListOrder(order = { "pk.section.sectionName", "pk.configKey" })
@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "sysconf", roleDel = "sysconf")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "DbConfigEntry")
*/
class DbConfigEntry extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\config\DbConfigEntry\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\DbConfigEntry\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "configValue")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TextTextual')
	@\net\dryuf\textual\DisplayUse(display = "textarea(60,8)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "sysconf", roleDel = "sysconf")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$configValue;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSection($section_)
	{
		$this->pk->setSection($section_);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\DbConfigSection\Pk')
	*/
	public function			getSection()
	{
		return $this->pk->getSection();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setConfigKey($configKey_)
	{
		$this->pk->setConfigKey($configKey_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getConfigKey()
	{
		return $this->pk->getConfigKey();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setConfigValue($configValue_)
	{
		$this->configValue = $configValue_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getConfigValue()
	{
		return $this->configValue;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\DbConfigEntry\Pk')
	*/
	public function			getPk()
	{
		return $this->pk;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($pk_)
	{
		$this->pk = $pk_;
	}
};


?>
