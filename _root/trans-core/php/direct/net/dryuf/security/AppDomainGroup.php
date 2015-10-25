<?php

namespace net\dryuf\security;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\RelationDefs(relations = {
	@\net\dryuf\meta\RelationDef(name = "roles", targetClass = "net.dryuf.security.AppDomainGroupRole")
})
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\security\AppDomainGroup\Pk', pkField = "pk", composClazz = 'net\dryuf\security\AppDomainDef', composPkClazz = 'string', composPath = "pk.domain", additionalPkFields = { "groupName" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "defaultDependencyRole", "roles" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "sysmeta", roleGet = "guest", roleSet = "sysmeta", roleDel = "sysmeta")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "AppDomainGroup")
*/
class AppDomainGroup extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\security\AppDomainGroup\Pk();
		$this->roles = new \net\dryuf\util\HashSet();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainGroup\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "defaultDependencyRole")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysmeta", roleGet = "guest", roleSet = "sysmeta", roleDel = "sysmeta")
	@\net\dryuf\meta\Mandatory(mandatory = true)
	*/
	protected			$defaultDependencyRole;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<net\dryuf\security\AppDomainGroupRole>')
	@\net\dryuf\meta\AssocDef(assocType = \net\dryuf\app\FieldDef::AST_Children, target = 'net\dryuf\security\AppDomainGroupRole')
	@\javax\persistence\OneToMany(fetch = \javax\persistence\FetchType::LAZY, cascade = \javax\persistence\CascadeType::ALL)
	@\javax\persistence\JoinColumns(value = {
		@\javax\persistence\JoinColumn(name = "domain", referencedColumnName = "domain"),
		@\javax\persistence\JoinColumn(name = "groupName", referencedColumnName = "groupName")
	})
	*/
	protected			$roles;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDomain($domain_)
	{
		$this->pk->setDomain($domain_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDomain()
	{
		return $this->pk->getDomain();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setGroupName($groupName_)
	{
		$this->pk->setGroupName($groupName_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getGroupName()
	{
		return $this->pk->getGroupName();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDefaultDependencyRole($defaultDependencyRole_)
	{
		$this->defaultDependencyRole = $defaultDependencyRole_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDefaultDependencyRole()
	{
		return $this->defaultDependencyRole;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<net\dryuf\security\AppDomainGroupRole>')
	*/
	public function			getRoles()
	{
		return $this->roles;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setRoles($roles_)
	{
		$this->roles = $roles_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainGroup\Pk')
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
