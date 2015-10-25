<?php

namespace net\dryuf\comp\gallery\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class GalleryHeaderDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\gallery\dao\GalleryHeaderDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\gallery\GalleryHeader');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryHeader')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadByRef($refBase, $refKey)
	{
		$result = $this->entityManager->createQuery("SELECT ent FROM GalleryHeader ent WHERE ent.refBase = ?1 AND ent.refKey = ?2")->setParameter(1, $refBase)->setParameter(2, $refKey)->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			updateHeaderStats($galleryId)
	{
		$this->entityManager->createQuery("UPDATE GalleryHeader h SET h.lastAdded = IFNULL((SELECT MAX(r.created) FROM GalleryRecord r WHERE r.pk.gallerySection.galleryId = h.galleryId), unix_timestamp()*1000), recordCount = (SELECT COUNT(*) FROM GalleryRecord r WHERE r.pk.gallerySection.galleryId = h.galleryId) WHERE h.galleryId = ?1")->setParameter(1, $galleryId)->executeUpdate();
	}
};


?>
