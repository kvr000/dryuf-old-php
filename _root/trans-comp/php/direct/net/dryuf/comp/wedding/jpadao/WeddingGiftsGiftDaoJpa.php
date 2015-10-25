<?php

namespace net\dryuf\comp\wedding\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class WeddingGiftsGiftDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\wedding\dao\WeddingGiftsGiftDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\wedding\WeddingGiftsGift');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\wedding\WeddingGiftsGift>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM WeddingGiftsGift WHERE pk.weddingGiftsId = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM WeddingGiftsGift obj WHERE obj.pk.weddingGiftsId = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			setReservedCode($weddingGiftsId, $displayName, $reservedCode)
	{
		return $this->entityManager->createQuery("UPDATE WeddingGiftsGift SET reservedCode = ?1 WHERE pk.weddingGiftsId = ?2 AND pk.displayName = ?3 AND reservedCode IS NULL")->setParameter(1, $reservedCode)->setParameter(2, $weddingGiftsId)->setParameter(3, $displayName)->executeUpdate() != 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			revertReservedCode($weddingGiftsId, $displayName, $reservedCode)
	{
		return $this->entityManager->createQuery("UPDATE WeddingGiftsGift SET reservedCode = NULL WHERE pk.weddingGiftsId = ?1 AND pk.displayName = ?2 AND reservedCode = ?3")->setParameter(1, $weddingGiftsId)->setParameter(2, $displayName)->setParameter(3, $reservedCode)->executeUpdate() != 0;
	}
};


?>
