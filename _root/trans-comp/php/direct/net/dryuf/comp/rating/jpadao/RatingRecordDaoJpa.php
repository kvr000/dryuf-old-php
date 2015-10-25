<?php

namespace net\dryuf\comp\rating\jpadao;


/**
@\org\springframework\stereotype\Repository
@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::SUPPORTS)
*/
class RatingRecordDaoJpa extends \net\dryuf\dao\DryufDaoContext implements \net\dryuf\comp\rating\dao\RatingRecordDao
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\comp\rating\RatingRecord');
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\rating\RatingRecord>')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			listByCompos($compos)
	{
		return $this->entityManager->createQuery("FROM RatingRecord WHERE ratingId = ?1 ORDER BY pk")->setParameter(1, $compos)->getResultList();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			removeByCompos($compos)
	{
		return $this->entityManager->createQuery("DELETE FROM RatingRecord obj WHERE obj.pk.ratingId = ?1")->setParameter(1, $compos)->executeUpdate();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\springframework\transaction\annotation\Transactional(value = "dryuf")
	@\javax\ejb\TransactionAttribute(value = \javax\ejb\TransactionAttributeType::REQUIRED)
	*/
	public function			addRatingValue($ratingId, $userId, $value)
	{
		$pk = new \net\dryuf\comp\rating\RatingRecord\Pk($ratingId, $userId);
		$ratingRecord = $this->loadByPk($pk);
		if (is_null($ratingRecord)) {
			$ratingRecord = new \net\dryuf\comp\rating\RatingRecord();
			$ratingRecord->setPk($pk);
			$ratingRecord->setValue($value);
			$this->insert($ratingRecord);
		}
		else {
			$ratingRecord->setValue($value);
		}
	}
};


?>
