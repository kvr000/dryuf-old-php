<?php

namespace net\dryuf\comp\poll\sql;


class SqlPollHandler extends \net\dryuf\core\Object implements \net\dryuf\comp\poll\PollHandler
{
	/**
	*/
	function			__construct($owner, $pollHeaderHolder)
	{
		parent::__construct();
		$this->pollHeaderHolder = $pollHeaderHolder;
		$this->pollHeader = $pollHeaderHolder->getEntity();
		$this->pollHeaderDao = $owner->getPollHeaderDao();
		$this->pollOptionDao = $owner->getPollOptionDao();
		$this->pollRecordDao = $owner->getPollRecordDao();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getCallerContext()
	{
		return $this->pollHeaderHolder->getRole();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			deletePoll()
	{
		$this->cleanPoll();
		$this->cleanOptions();
		$this->pollHeaderDao->remove($this->pollHeader);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanPoll()
	{
		$this->pollOptionDao->removeByCompos($this->pollHeader->getPollId());
		$this->updateHeader();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanOptions()
	{
		$this->pollOptionDao->removeByCompos($this->pollHeader->getPollId());
		$this->updateHeader();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			updateHeader()
	{
		$this->pollHeaderDao->updateStatistics($this->pollHeader->getPollId());
		$this->pollHeader = $this->pollHeaderDao->loadByPk($this->pollHeader->getPollId());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHeader')
	*/
	public function			getPollDetail()
	{
		return $this->pollHeader;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	public function			getHolder()
	{
		return $this->pollHeaderHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\poll\PollOption>')
	*/
	public function			getPollOptions()
	{
		return $this->pollOptionDao->listByCompos($this->pollHeader->getPollId());
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			getPollTotal()
	{
		return $this->pollHeader->getTotalVotes();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addPollVote($userId, $optionId)
	{
		$this->pollRecordDao->addPollVote($this->pollHeader->getPollId(), $userId, $optionId);
		$this->updateHeader();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollHeaderDao')
	*/
	protected			$pollHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollOptionDao')
	*/
	protected			$pollOptionDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollRecordDao')
	*/
	protected			$pollRecordDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHeader')
	*/
	protected			$pollHeader;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	protected			$pollHeaderHolder;
};


?>
