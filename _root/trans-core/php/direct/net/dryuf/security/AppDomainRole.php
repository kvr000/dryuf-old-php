<?php

namespace net\dryuf\security;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\security\AppDomainRole\Pk', pkField = "pk", composClazz = 'net\dryuf\security\AppDomainDef', composPkClazz = 'string', composPath = "pk.domain", additionalPkFields = { "roleName" })
@\net\dryuf\meta\FieldOrder(fields = { "pk", "defaultDependencyRole" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "sysmeta", roleGet = "guest", roleSet = "sysmeta", roleDel = "sysmeta")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "AppDomainRole")
*/
class AppDomainRole extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\security\AppDomainRole\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainRole\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\javax\persistence\Column(name = "defaultDependencyRole")
	@\net\dryuf\textual\TextualUse(textual = 'net\dryuf\textual\TrimTextual')
	@\net\dryuf\textual\DisplayUse(display = "text(160px)")
	@\net\dryuf\meta\FieldRoles(roleNew = "sysmeta", roleGet = "guest", roleSet = "sysmeta", roleDel = "sysmeta")
	@\net\dryuf\meta\Mandatory(mandatory = true, doMandatory = "\"\"")
	*/
	protected			$defaultDependencyRole = "";

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
	public function			setRoleName($roleName_)
	{
		$this->pk->setRoleName($roleName_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getRoleName()
	{
		return $this->pk->getRoleName();
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
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainRole\Pk')
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
