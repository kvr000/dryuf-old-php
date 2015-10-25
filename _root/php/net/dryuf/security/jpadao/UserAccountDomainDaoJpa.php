<?php

namespace net\dryuf\security\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class UserAccountDomainDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\security\dao\UserAccountDomainDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\security\UserAccountDomain');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\security\UserAccountDomain>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM UserAccountDomain WHERE pk.userId = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM UserAccountDomain obj WHERE obj.pk.userId = ?1")->setParameter(1, $compos)->executeUpdate();
	}
};


?>
