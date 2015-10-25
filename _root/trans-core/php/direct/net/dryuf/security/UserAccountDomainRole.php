<?php

namespace net\dryuf\security;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\security\UserAccountDomainRole\Pk', pkField = "pk", composClazz = 'net\dryuf\security\UserAccountDomain', composPkClazz = 'net\dryuf\security\UserAccountDomain\Pk', composPath = "pk.domain", additionalPkFields = { "roleName" })
@\net\dryuf\meta\FieldOrder(fields = { "pk" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "admin", roleSet = "sysconf", roleDel = "sysconf")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "UserAccountDomainRole")
*/
class UserAccountDomainRole extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\security\UserAccountDomainRole\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccountDomainRole\Pk')
	@\javax\persistence\EmbeddedId
	*/
	protected			$pk;

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDomain($domain_)
	{
		$this->pk->setDomain($domain_);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccountDomain\Pk')
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
	@\net\dryuf\core\Type(type = 'net\dryuf\security\UserAccountDomainRole\Pk')
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
