<?php

namespace net\dryuf\security\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class AppDomainAliasDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\security\dao\AppDomainAliasDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\security\AppDomainAlias');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\security\AppDomainAlias>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM AppDomainAlias WHERE pk.domain = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM AppDomainAlias obj WHERE obj.pk.domain = ?1")->setParameter(1, $compos)->executeUpdate();
	}
};


?>
