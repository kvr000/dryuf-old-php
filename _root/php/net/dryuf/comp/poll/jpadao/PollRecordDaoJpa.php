<?php

namespace net\dryuf\comp\poll\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class PollRecordDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\poll\dao\PollRecordDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\poll\PollRecord');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\poll\PollRecord>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM PollRecord WHERE pollId = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM PollRecord obj WHERE obj.pk.pollId = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			addPollVote($pollId, $userId, $voteOption)
	{
		$pk = new \net\dryuf\comp\poll\PollRecord\Pk($pollId, $userId);
		$pollRecord = $this->loadByPk($pk);
		if (is_null($pollRecord)) {
			$pollRecord = new \net\dryuf\comp\poll\PollRecord();
			$pollRecord->setPk($pk);
			$pollRecord->setVoteOption($voteOption);
			$this->insert($pollRecord);
		}
		else {
			$pollRecord->setVoteOption($voteOption);
		}
	}
};


?>
