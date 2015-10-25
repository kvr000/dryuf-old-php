<?php

namespace net\dryuf\comp\poll\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class PollHeaderDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\poll\dao\PollHeaderDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\poll\PollHeader');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\poll\PollHeader>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM PollHeader WHERE groupId = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM PollHeader obj WHERE obj.pk.groupId = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			updateStatistics($pollId)
	{
		$this->entityManager->flush();
		$this->entityManager->createQuery("UPDATE PollOption po SET po.voteCount = (SELECT COUNT(*) FROM PollRecord pr WHERE pr.pk.pollId = po.pk.pollId AND pr.voteOption = po.pk.optionId) WHERE po.pk.pollId = :pollId")->setParameter("pollId", $pollId)->executeUpdate();
		$this->entityManager->createQuery("UPDATE PollHeader ph SET ph.totalVotes = (SELECT COUNT(*) FROM PollRecord pr WHERE pr.pk.pollId = ph.pollId) WHERE ph.pollId = :pollId")->setParameter("pollId", $pollId)->executeUpdate();
	}
};


?>
