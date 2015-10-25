<?php

namespace net\dryuf\comp\rating\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class RatingHeaderDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\rating\dao\RatingHeaderDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\rating\RatingHeader');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			updateStatistics($ratingId)
	{
		$this->entityManager->flush();
		$this->entityManager->createQuery("UPDATE RatingHeader rh SET counts = COALESCE((SELECT COUNT(*) FROM RatingRecord rr WHERE rr.pk.ratingId = rh.ratingId), 0), total = COALESCE((SELECT SUM(value) FROM RatingRecord rr WHERE rr.pk.ratingId = rh.ratingId), 0) WHERE rh.ratingId = :ratingId")->setParameter("ratingId", $ratingId)->executeUpdate();
		$this->entityManager->createQuery("UPDATE RatingHeader rh SET rating = COALESCE(rh.total/COALESCE(CASE WHEN rh.counts = 0 THEN 1 ELSE rh.counts END, 0), 0) WHERE rh.ratingId = :ratingId")->setParameter("ratingId", $ratingId)->executeUpdate();
	}
};


?>
