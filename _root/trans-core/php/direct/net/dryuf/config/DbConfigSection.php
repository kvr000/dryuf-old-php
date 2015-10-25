<?php

namespace net\dryuf\config;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "new", isStatic = true, guiDef = "target=this", roleAction = "sysconf"),
	@\net\dryuf\meta\ActionDef(name = "edit", isStatic = false, guiDef = "target=this", roleAction = "sysconf"),
	@\net\dryuf\meta\ActionDef(name = "remove", isStatic = false, guiDef = "target=this", roleAction = "sysconf")
})
@\net\dryuf\meta\RelationDefs(relations = {
	@\net\dryuf\meta\RelationDef(name = "entries", targetClass = "net.dryuf.config.DbConfigEntry")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\config\DbConfigSection\Pk', pkField = "pk", composClazz = 'net\dryuf\config\DbConfigProfile', composPkClazz = 'string', composPath = "pk.profileName", additionalPkFields = { "sectionName" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "entries" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\ListOrder(order = { "pk.sectionName" })
@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "sysconf", roleDel = "sysconf")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "DbConfigSection")
*/
class DbConfigSection extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\config\DbConfigSection\Pk();
		$this->entries = new \net\dryuf\util\HashSet();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\DbConfigSection\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<net\dryuf\config\DbConfigEntry>')
	@\net\dryuf\meta\AssocDef(assocType = \net\dryuf\app\FieldDef::AST_Children, target = 'net\dryuf\config\DbConfigEntry')
	@\javax\persistence\OneToMany(fetch = \javax\persistence\FetchType::LAZY, cascade = \javax\persistence\CascadeType::ALL)
	@\javax\persistence\JoinColumns(value = {
		@\javax\persistence\JoinColumn(name = "profileName", referencedColumnName = "profileName"),
		@\javax\persistence\JoinColumn(name = "sectionName", referencedColumnName = "sectionName")
	})
	@\javax\persistence\OrderBy(value = "pk.section.sectionName, pk.configKey")
	*/
	protected			$entries;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setProfileName($profileName_)
	{
		$this->pk->setProfileName($profileName_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getProfileName()
	{
		return $this->pk->getProfileName();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setSectionName($sectionName_)
	{
		$this->pk->setSectionName($sectionName_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getSectionName()
	{
		return $this->pk->getSectionName();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<net\dryuf\config\DbConfigEntry>')
	*/
	public function			getEntries()
	{
		return $this->entries;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setEntries($entries_)
	{
		$this->entries = $entries_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\DbConfigSection\Pk')
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
