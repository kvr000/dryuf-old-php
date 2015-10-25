<?php

namespace net\dryuf\comp\forum\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class ForumHeaderDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\forum\dao\ForumHeaderDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\forum\ForumHeader');
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			getMaxCounter($forumId)
	{
		$result = $this->entityManager->createQuery("SELECT MAX(pk.counter) FROM ForumRecord WHERE pk.forumId = ?1")->setParameter(1, $forumId)->getResultList();
		return $result->isEmpty() ? null : $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			updateRecordStats($forumId)
	{
		$this->entityManager->createQuery("UPDATE\tForumHeader h\nSET\n\th.lastAdded = IFNULL((SELECT MAX(created) FROM ForumRecord WHERE forumId = h.forumId), unix_timestamp()),\n\th.recordCount = (SELECT COUNT(*) FROM ForumRecord r WHERE r.pk.forumId = h.forumId)\nWHERE\n\th.forumId = ?1")->setParameter(1, $forumId)->executeUpdate();
	}
};


?>
