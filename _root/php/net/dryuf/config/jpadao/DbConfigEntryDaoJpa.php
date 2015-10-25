<?php

namespace net\dryuf\config\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class DbConfigEntryDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\config\dao\DbConfigEntryDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\config\DbConfigEntry');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\config\DbConfigEntry>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM DbConfigEntry WHERE pk.section = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM DbConfigEntry obj WHERE obj.pk.section = ?1")->setParameter(1, $compos)->executeUpdate();
	}
};


?>
