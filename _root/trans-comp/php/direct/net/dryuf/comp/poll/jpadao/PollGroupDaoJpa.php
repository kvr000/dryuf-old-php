<?php

namespace net\dryuf\comp\poll\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class PollGroupDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\poll\dao\PollGroupDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\poll\PollGroup');
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	*/
	public function			getLatestHeaderId($groupId)
	{
		return $this->entityManager->createQuery("SELECT MAX(ph.pollId) FROM PollHeader ph WHERE ph.groupId = :groupId")->setParameter("groupId", $groupId)->getSingleResult();
	}
};


?>
