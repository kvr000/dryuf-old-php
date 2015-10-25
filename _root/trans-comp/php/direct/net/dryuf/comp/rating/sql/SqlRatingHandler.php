<?php

namespace net\dryuf\comp\rating\sql;


class SqlRatingHandler extends \net\dryuf\core\Object implements \net\dryuf\comp\rating\RatingHandler
{
	/**
	*/
	function			__construct($sqlRatingBo, $ratingHeaderHolder, $maxRating)
	{
		parent::__construct();
		$this->ratingHeaderDao = $sqlRatingBo->getRatingHeaderDao();
		$this->ratingRecordDao = $sqlRatingBo->getRatingRecordDao();
		$this->callerContext = $ratingHeaderHolder->getRole();
		$this->ratingHeaderHolder = $ratingHeaderHolder;
		$this->ratingHeader = $ratingHeaderHolder->getEntity();
		$this->maxRating = $maxRating;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			deleteRating()
	{
		$this->cleanRating();
		$this->ratingHeaderDao->removeByPk($this->ratingHeader->getRatingId());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanRating()
	{
		$this->ratingRecordDao->removeByCompos($this->ratingHeader->getRatingId());
		$this->updateHeader();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingHeader')
	*/
	public function			getRatingDetail()
	{
		return $this->ratingHeader;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getMaxRating()
	{
		return $this->maxRating;
	}

	/**
	@\net\dryuf\core\Type(type = 'double')
	*/
	public function			getRatingValue()
	{
		return $this->ratingHeader->getRating();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			updateStat()
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addRating($userId, $value)
	{
		if ($value > $this->maxRating)
			throw new \net\dryuf\core\RuntimeException("value > maxRating");
		try {
			$this->ratingRecordDao->runTransactionedNew(
				function () use ($userId, $value) {
					$this->ratingRecordDao->addRatingValue($this->ratingHeader->getRatingId(), $userId, $value);
					$this->updateHeader();
					return null;
				}
			);
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			removeUserRating($userId)
	{
		try {
			$this->ratingRecordDao->runTransactionedNew(
				function () use ($userId) {
					$this->ratingRecordDao->removeByPk(new \net\dryuf\comp\rating\RatingRecord\Pk($this->ratingHeader->getRatingId(), $userId));
					$this->updateHeader();
					return null;
				}
			);
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\rating\RatingRecord>')
	*/
	public function			listRatings()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("listRatings");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			refresh()
	{
		try {
			$this->ratingHeader = $this->ratingHeaderDao->runTransactionedNew(
				function () {
					return $this->ratingHeaderDao->loadByPk($this->ratingHeader->getPk());
				}
			);
		}
		catch (\net\dryuf\core\Exception $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		$this->ratingHeaderHolder->setEntity($this->ratingHeader);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	protected function		updateHeader()
	{
		$this->ratingHeaderDao->updateStatistics($this->ratingHeader->getRatingId());
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$maxRating = 0;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getCallerContext()
	{
		return $this->callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingHeader')
	*/
	protected			$ratingHeader;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\rating\RatingHeader>')
	*/
	protected			$ratingHeaderHolder;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\dao\RatingHeaderDao')
	*/
	protected			$ratingHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\dao\RatingRecordDao')
	*/
	protected			$ratingRecordDao;
};


?>
