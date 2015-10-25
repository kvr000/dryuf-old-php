<?php

namespace net\dryuf\security;


/**
@\net\dryuf\meta\ActionDefs(actions = { })
@\net\dryuf\meta\FilterDefs(filters = { })
@\net\dryuf\meta\PKeyDef(pkEmbedded = true, pkClazz = 'net\dryuf\security\AppDomainAlias\Pk', pkField = "pk", composClazz = 'net\dryuf\security\AppDomainDef', composPkClazz = 'string', composPath = "pk.domain", additionalPkFields = { "domainAlias" })
@\net\dryuf\meta\FieldOrder(fields = { "pk" })
@\net\dryuf\meta\ViewsList(views = {
	@\net\dryuf\meta\ViewInfo(name = "Default")
})
@\net\dryuf\meta\FieldRoles(roleNew = "sysconf", roleGet = "sysconf", roleSet = "sysconf", roleDel = "sysconf")
@\javax\persistence\Entity
@\javax\persistence\Table(name = "AppDomainAlias")
*/
class AppDomainAlias extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->pk = new \net\dryuf\security\AppDomainAlias\Pk();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainAlias\Pk')
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
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDomain()
	{
		return $this->pk->getDomain();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setDomainAlias($domainAlias_)
	{
		$this->pk->setDomainAlias($domainAlias_);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDomainAlias()
	{
		return $this->pk->getDomainAlias();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainAlias\Pk')
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
