<?php

namespace net\dryuf\comp\gallery\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class GalleryRecordDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\gallery\dao\GalleryRecordDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\gallery\GalleryRecord');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GalleryRecord>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM GalleryRecord WHERE pk.gallerySection = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM GalleryRecord obj WHERE obj.pk.gallerySection = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadByDisplay($gallerySectionPk, $displayName)
	{
		$result = $this->entityManager->createQuery("SELECT ent FROM GalleryRecord ent WHERE ent.pk.gallerySection = ?1 AND ent.displayName = ?2")->setParameter(1, $gallerySectionPk)->setParameter(2, $displayName)->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Long')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			getMaxRecordCounter($gallerySectionPk)
	{
		$result = $this->entityManager->createQuery("SELECT MAX(gr.pk.recordCounter) FROM GalleryRecord gr WHERE gr.pk.gallerySection = ?1")->setParameter(1, $gallerySectionPk)->getResultList();
		return $result->isEmpty() ? null : $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadSectionedPrevious($recordPk)
	{
		$result = $this->entityManager->createQuery("SELECT r FROM GalleryRecord r WHERE r.pk.gallerySection = ?1 AND r.pk.recordCounter < ?2 ORDER BY r.pk.recordCounter DESC")->setParameter(1, $recordPk->getGallerySection())->setParameter(2, $recordPk->getRecordCounter())->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadSectionedNext($recordPk)
	{
		$result = $this->entityManager->createQuery("SELECT r FROM GalleryRecord r WHERE r.pk.gallerySection = ?1 AND r.pk.recordCounter > ?2 ORDER BY r.pk.recordCounter ASC")->setParameter(1, $recordPk->getGallerySection())->setParameter(2, $recordPk->getRecordCounter())->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadFullPrevious($recordPk)
	{
		$result = $this->entityManager->createQuery("SELECT r FROM GalleryRecord r WHERE (r.pk.gallerySection = ?1 AND r.pk.recordCounter < ?2) OR (r.pk.gallerySection.galleryId = ?3 AND r.pk.gallerySection.sectionCounter < ?4) ORDER BY r.pk DESC")->setParameter(1, $recordPk->getGallerySection())->setParameter(2, $recordPk->getRecordCounter())->setParameter(3, $recordPk->getGallerySection()->getGalleryId())->setParameter(4, $recordPk->getGallerySection()->getSectionCounter())->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	*/
	public function			loadFullNext($recordPk)
	{
		$result = $this->entityManager->createQuery("SELECT r FROM GalleryRecord r WHERE (pk.gallerySection = ?1 AND pk.recordCounter > ?2) OR (pk.gallerySection.galleryId = ?3 AND pk.gallerySection.sectionCounter > ?4) ORDER BY pk.gallerySection ASC, pk.recordCounter ASC")->setParameter(1, $recordPk->getGallerySection())->setParameter(2, $recordPk->getRecordCounter())->setParameter(3, $recordPk->getGallerySection()->getGalleryId())->setParameter(4, $recordPk->getGallerySection()->getSectionCounter())->getResultList();
		if ($result->isEmpty())
			return null;
		return $result->get(0);
	}
};


?>
