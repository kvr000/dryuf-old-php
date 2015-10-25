<?php

namespace net\dryuf\comp\poll\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class PollOptionDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\poll\dao\PollOptionDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\poll\PollOption');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\poll\PollOption>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM PollOption WHERE pk.pollId = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM PollOption obj WHERE obj.pk.pollId = ?1")->setParameter(1, $compos)->executeUpdate();
	}
};


?>
