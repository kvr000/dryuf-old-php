<?php

namespace net\dryuf\security\oper;


class UserAccountDomainRoleOper extends \net\dryuf\oper\DaoObjectOperController
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
		$this->setDataClass('net\dryuf\security\UserAccountDomainRole');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		checkDataValidity($callerContext, $data)
	{
		if ($data->containsKey("pk")) {
			$pkData = $data->get("pkData");
			if ($pkData->containsKey("domain")) {
				$domain = \net\dryuf\core\ConversionUtil::convertToClass('string', $pkData->get("domain"));
				if (!($domain === $this->userAccountBo->getAppDomainId()))
					\net\dryuf\validation\DataValidatorUtil::throwValidationError(null, "pk.domain", 
						$callerContext->getUiContext()->localizeArgs('net\dryuf\security\oper\UserAccountOper', "Cannot set role for different domain: {0}", 
							array(
								$domain
							)));
			}
			if ($pkData->containsKey("roleName")) {
				$roleName = \net\dryuf\core\ConversionUtil::convertToClass('string', $pkData->get("roleName"));
				if (!is_null(($allowedRole = $this->userAccountBo->checkRequiredRoleForRole($callerContext, $roleName))))
					\net\dryuf\validation\DataValidatorUtil::throwValidationError(null, "pk.roleName", 
						$callerContext->getUiContext()->localizeArgs('net\dryuf\security\oper\UserAccountOper', "Cannot assign role {0}, allowed only for {1}", 
							array(
								$roleName,
								$allowedRole
							)));
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	@\net\dryuf\oper\ObjectOperRules(value = "loadRoleRef", reqRole = "free", isStatic = true, isFinal = true, parameters = {
		'net\dryuf\textual\DotIdentifierTextual'
	})
	*/
	public function			loadRoleRef($presenter, $ownerHolder, $roleName)
	{
		return $this->appDomainRoleDao->retrieveDynamic($ownerHolder, new \net\dryuf\security\AppDomainRole\Pk($this->userAccountBo->getAppDomainId(), $roleName))->getEntity()->getRoleName();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\String>')
	@\net\dryuf\oper\ObjectOperRules(value = "listAllRoleRefs", reqRole = "free", isStatic = true, isFinal = true)
	*/
	public function			listAllRoleRefs($presenter, $ownerHolder)
	{
		$domainHolder = $this->appDomainDefDao->retrieveDynamic($ownerHolder, $this->userAccountBo->getAppDomainId());
		$results = new \net\dryuf\util\LinkedList();
		$this->appDomainRoleDao->listDynamic($results, $domainHolder, \net\dryuf\util\MapUtil::createStringNativeHashMap("pk.domain", $this->userAccountBo->getAppDomainId()), null, null, null);
		return \net\dryuf\util\Collections::transform($results, function ($appDomainRole) { return $appDomainRole->getEntity()->getRoleName(); });
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	@\net\dryuf\oper\ObjectOperRules(value = "listNewRoleRefs", reqRole = "free", isStatic = true, isFinal = true)
	*/
	public function			listNewRoleRefs($presenter, $ownerHolder)
	{
		return $this->userAccountBo->listAddableRoles($ownerHolder->getRole());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\security\UserAccountDomainRole>')
	*/
	public function			executeStaticCreate($operContext, $ownerHolder, $data)
	{
		$this->checkDataValidity($ownerHolder->getRole(), $data);
		return parent::executeStaticCreate($operContext, $ownerHolder, $data);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\security\UserAccountDomainRole>')
	*/
	public function			executeObjectUpdate($operContext, $objectHolder, $data)
	{
		$this->checkDataValidity($objectHolder->getRole(), $data);
		return parent::executeObjectUpdate($operContext, $objectHolder, $data);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\bo\UserAccountBo')
	@\javax\inject\Inject
	*/
	protected			$userAccountBo;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\AppDomainDefDao')
	@\javax\inject\Inject
	*/
	protected			$appDomainDefDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\AppDomainGroupDao')
	@\javax\inject\Inject
	*/
	protected			$appDomainGroupDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\dao\AppDomainRoleDao')
	@\javax\inject\Inject
	*/
	protected			$appDomainRoleDao;
};


?>
