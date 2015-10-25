<?php

namespace net\dryuf\comp\rating\sql;


class SqlRatingBo extends \net\dryuf\core\Object implements \net\dryuf\comp\rating\bo\RatingBo
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\rating\RatingHeader>')
	*/
	public function			getRatingObject($callerContext, $ratingId)
	{
		$objects = new \net\dryuf\util\LinkedList();
		if ($this->ratingHeaderDao->listDynamic($objects, \net\dryuf\core\EntityHolder::createRoleOnly($callerContext), \net\dryuf\util\MapUtil::createStringNativeHashMap("ratingId", $ratingId), null, null, null) == 0)
			return null;
		return $objects->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\rating\RatingHeader>')
	*/
	public function			getRatingObjectRef($callerContext, $refBase, $refKey)
	{
		$objects = new \net\dryuf\util\LinkedList();
		if ($this->ratingHeaderDao->listDynamic($objects, \net\dryuf\core\EntityHolder::createRoleOnly($callerContext), \net\dryuf\util\MapUtil::createStringNativeHashMap("refBase", $refBase, "refKey", $refKey), null, null, null) == 0)
			return null;
		return $objects->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\rating\RatingHeader>')
	*/
	public function			getCreateRatingObjectRef($callerContext, $refBase, $refKey)
	{
		if (is_null(($objectHolder = $this->getRatingObjectRef($callerContext, $refBase, $refKey)))) {
			try {
				$header = new \net\dryuf\comp\rating\RatingHeader();
				$header->setRefBase($refBase);
				$header->setRefKey($refKey);
				$this->ratingHeaderDao->insert($header);
			}
			catch (\net\dryuf\dao\DaoUniqueConstraintException $ex) {
			}
			if (is_null(($objectHolder = $this->getRatingObjectRef($callerContext, $refBase, $refKey)))) {
				throw new \net\dryuf\core\RuntimeException("failed to create rating object");
			}
		}
		return $objectHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingHandler')
	*/
	public function			openCreateRatingRef($callerContext, $refBase, $refKey, $maxRating)
	{
		return new \net\dryuf\comp\rating\sql\SqlRatingHandler($this, $this->getCreateRatingObjectRef($callerContext, $refBase, $refKey), $maxRating);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deleteRatingStatic($callerContext, $objectId)
	{
		$this->cleanRating($objectId);
		$this->ratingHeaderDao->removeByPk($objectId);
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanRating($ratingId)
	{
		$this->ratingRecordDao->removeByCompos($ratingId);
		$this->ratingHeaderDao->updateStatistics($ratingId);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deleteRatingStaticRef($callerContext, $refBase, $refKey)
	{
		if (!is_null(($objectHolder = $this->getRatingObjectRef($callerContext, $refBase, $refKey)))) {
			$this->deleteRatingStatic($callerContext, $objectHolder->getEntity()->getRatingId());
			return true;
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\dao\RatingHeaderDao')
	@\javax\inject\Inject
	*/
	protected			$ratingHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\dao\RatingHeaderDao')
	*/
	public function			getRatingHeaderDao()
	{
		return $this->ratingHeaderDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\dao\RatingRecordDao')
	@\javax\inject\Inject
	*/
	protected			$ratingRecordDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\dao\RatingRecordDao')
	*/
	public function			getRatingRecordDao()
	{
		return $this->ratingRecordDao;
	}
};


?>
