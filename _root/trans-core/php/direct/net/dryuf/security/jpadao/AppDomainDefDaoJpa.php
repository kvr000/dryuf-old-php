<?php

namespace net\dryuf\security\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class AppDomainDefDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\security\dao\AppDomainDefDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\security\AppDomainDef');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\security\AppDomainDef')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadByAlias($domainAlias)
	{
		$result = $this->entityManager->createQuery("SELECT dd FROM DomainDef dd WHERE dd.domain IN (SELECT da.domain FROM DomainAlias da WHERE da.domainAlias = ?1)")->setParameter(1, $domainAlias)->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}
};


?>
