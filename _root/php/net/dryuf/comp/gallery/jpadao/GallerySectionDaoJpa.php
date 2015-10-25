<?php

namespace net\dryuf\comp\gallery\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class GallerySectionDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\gallery\dao\GallerySectionDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\gallery\GallerySection');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GallerySection>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM GallerySection WHERE pk.galleryId = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM GallerySection obj WHERE obj.pk.galleryId = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GallerySection')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadByDisplay($galleryId, $displayName)
	{
		$result = $this->entityManager->createQuery("SELECT ent FROM GallerySection ent WHERE ent.pk.galleryId = ?1 AND ent.displayName = ?2")->setParameter(1, $galleryId)->setParameter(2, $displayName)->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			updateSectionStats($gallerySectionPk)
	{
		$this->entityManager->createQuery("UPDATE GallerySection s SET s.lastAdded = IFNULL((SELECT MAX(r.created) FROM GalleryRecord r WHERE r.pk.gallerySection = s.pk), unix_timestamp()*1000), recordCount = (SELECT COUNT(*) FROM GalleryRecord r WHERE r.pk.gallerySection = s.pk) WHERE s.pk = ?1")->setParameter(1, $gallerySectionPk)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			getMaxSectionCounter($galleryId)
	{
		$result = $this->entityManager->createQuery("SELECT MAX(gs.pk.sectionCounter) FROM GallerySection gs WHERE gs.pk.galleryId = ?1")->setParameter(1, $galleryId)->getResultList();
		return $result->isEmpty() ? null : $result->get(0);
	}
};


?>
