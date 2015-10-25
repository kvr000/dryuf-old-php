<?php

namespace net\dryuf\config;


/**
@\net\dryuf\meta\ActionDefs(actions = {
	@\net\dryuf\meta\ActionDef(name = "new", isStatic = true, guiDef = "target=this", roleAction = "sysconf"),
	@\net\dryuf\meta\ActionDef(name = "edit", isStatic = false, guiDef = "target=this", roleAction = "sysconf"),
	@\net\dryuf\meta\ActionDef(name = "remove", isStatic = false, guiDef = "target=this", roleAction = "sysconf"),
	@\net\dryuf\meta\ActionDef(name = "manageSections", isStatic = false, guiDef = "relation=sections", roleAction = "sysconf")
})
@\net\dryuf\meta\RelationDefs(relations = {
	@\net\dryuf\meta\RelationDef(name = "sections", targetClass = "net.dryuf.config.DbConfigSection")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = false, pkClazz = 'string', pkField = "profileName", composClazz = 'void', composPkClazz = 'void', composPath = "", additionalPkFields = { })
@\net\dryuf\meta\FieldOrder(fields = { "profileName" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "sysconf", roleDel = "sysconf")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "DbConfigProfile")
*/
class DbConfigProfile extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "profileName")
	@\javax\persistence\Id
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "extreme", roleDel = "sysconf")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$profileName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPk()
	{
		return $this->profileName;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setPk($profileName_)
	{
		$this->profileName = $profileName_;
	}

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
};


?>
