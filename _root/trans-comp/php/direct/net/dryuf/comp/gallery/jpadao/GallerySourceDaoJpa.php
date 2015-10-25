<?php

namespace net\dryuf\comp\gallery\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class GallerySourceDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\gallery\dao\GallerySourceDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\gallery\GallerySource');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySource>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM GallerySource WHERE pk.record = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM GallerySource obj WHERE obj.pk.record = ?1")->setParameter(1, $compos)->executeUpdate();
	}
};


?>
