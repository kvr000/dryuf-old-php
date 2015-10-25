<?php

namespace net\dryuf\comp\poll\sql;


class SqlPollGroupHandler extends \net\dryuf\core\Object implements \net\dryuf\comp\poll\PollGroupHandler
{
	/**
	*/
	function			__construct($owner, $pollGroupHolder)
	{
		parent::__construct();
		$this->owner = $owner;
		$this->pollGroupHolder = $pollGroupHolder;
		$this->pollGroup = $pollGroupHolder->getEntity();
		$this->pollGroupDao = $owner->getPollGroupDao();
		$this->pollHeaderDao = $owner->getPollHeaderDao();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollGroup>')
	*/
	public function			getHolder()
	{
		return $this->pollGroupHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>>')
	*/
	public function			listHeaders()
	{
		$headers = new \net\dryuf\util\LinkedList();
		$this->pollHeaderDao->listDynamic($headers, $this->pollGroupHolder, null, null, null, null);
		return $headers;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	public function			getLastHeader()
	{
		$pollId = $this->pollGroupDao->getLatestHeaderId($this->pollGroup->getGroupId());
		if (is_null($pollId))
			return null;
		return $this->pollHeaderDao->retrieveDynamic($this->pollGroupHolder, $pollId);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHandler')
	*/
	public function			createPoll($pollHeader)
	{
		$pollHeader->setGroupId($this->pollGroup->getGroupId());
		$this->pollHeaderDao->insert($pollHeader);
		return new \net\dryuf\comp\poll\sql\SqlPollHandler($this->owner, new \net\dryuf\core\EntityHolder($pollHeader, $this->pollGroupHolder->getRole()));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHandler')
	*/
	public function			openPoll($pollId)
	{
		$pollHeaderHolder = $this->pollHeaderDao->retrieveDynamic($this->pollGroupHolder, $pollId);
		if (is_null($pollHeaderHolder))
			return null;
		return new \net\dryuf\comp\poll\sql\SqlPollHandler($this->owner, $pollHeaderHolder);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanPolls()
	{
		foreach ($this->listHeaders() as $pollHeaderHolder) {
			$this->owner->deletePollStatic($pollHeaderHolder->getRole(), $pollHeaderHolder->getEntity()->getPollId());
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			deleteGroup()
	{
		$this->cleanPolls();
		$this->pollGroupDao->removeByPk($this->pollGroup->getGroupId());
		$this->pollGroup = null;
		$this->pollGroupHolder = null;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollGroupDao')
	*/
	protected			$pollGroupDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollOptionDao')
	*/
	protected			$pollOptionDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollHeaderDao')
	*/
	protected			$pollHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollRecordDao')
	*/
	protected			$pollRecordDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollGroup')
	*/
	protected			$pollGroup;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollGroup>')
	*/
	protected			$pollGroupHolder;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\sql\SqlPollBo')
	*/
	protected			$owner;
};


?>
