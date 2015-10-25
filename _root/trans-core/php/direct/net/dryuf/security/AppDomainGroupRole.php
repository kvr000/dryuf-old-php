<?php

namespace net\dryuf\security;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\security\AppDomainGroupRole\Pk', pkField = "pk", composClazz = 'net\dryuf\security\AppDomainGroup', composPkClazz = 'net\dryuf\security\AppDomainGroup\Pk', composPath = "pk.domainGroup", additionalPkFields = { "roleName" })
@\net\dryuf\meta\FieldOrder(fields = { "pk" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "sysmeta", roleGet = "guest", roleSet = "sysmeta", roleDel = "sysmeta")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "AppDomainGroupRole")
*/
class AppDomainGroupRole extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\security\AppDomainGroupRole\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainGroupRole\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDomainGroup($domainGroup_)
	{
		$this->pk->setDomainGroup($domainGroup_);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainGroup\Pk')
	*/
	public function			getDomainGroup()
	{
		return $this->pk->getDomainGroup();
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
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainGroupRole\Pk')
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
