<?php

namespace net\dryuf\comp\forum\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class ForumRecordDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\forum\dao\ForumRecordDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\forum\ForumRecord');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\forum\ForumRecord>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM ForumRecord WHERE pk.forumId = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM ForumRecord obj WHERE obj.pk.forumId = ?1")->setParameter(1, $compos)->executeUpdate();
	}
};


?>
