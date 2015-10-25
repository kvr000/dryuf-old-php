<?php

namespace net\dryuf\comp\poll\sql;


class SqlPollBo extends \net\dryuf\core\Object implements \net\dryuf\comp\poll\bo\PollBo
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollGroup>')
	*/
	public function			getGroupObjectRef($callerContext, $refBase, $refKey)
	{
		$groups = new \net\dryuf\util\LinkedList();
		if ($this->pollGroupDao->listDynamic($groups, \net\dryuf\core\EntityHolder::createRoleOnly($callerContext), \net\dryuf\util\MapUtil::createStringNativeHashMap("refBase", $refBase, "refKey", $refKey), null, null, null) == 0)
			return null;
		return $groups->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollGroup>')
	*/
	public function			getGroupObject($callerContext, $groupId)
	{
		$groups = new \net\dryuf\util\LinkedList();
		if ($this->pollGroupDao->listDynamic($groups, \net\dryuf\core\EntityHolder::createRoleOnly($callerContext), \net\dryuf\util\MapUtil::createStringNativeHashMap("groupId", $groupId), null, null, null) == 0)
			return null;
		return $groups->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollGroup>')
	*/
	public function			getCreateGroupObjectRef($callerContext, $refBase, $refKey)
	{
		if (is_null(($groupHolder = $this->getGroupObjectRef($callerContext, $refBase, $refKey)))) {
			try {
				$header = new \net\dryuf\comp\poll\PollGroup();
				$header->setRefBase($refBase);
				$header->setRefKey($refKey);
				$this->pollGroupDao->insert($header);
			}
			catch (\net\dryuf\dao\DaoUniqueConstraintException $ex) {
			}
			if (is_null(($groupHolder = $this->getGroupObjectRef($callerContext, $refBase, $refKey)))) {
				throw new \net\dryuf\core\RuntimeException("failed to create poll group");
			}
		}
		return $groupHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollGroupHandler')
	*/
	public function			openCreateGroupRef($callerContext, $refBase, $refKey)
	{
		return new \net\dryuf\comp\poll\sql\SqlPollGroupHandler($this, $this->getCreateGroupObjectRef($callerContext, $refBase, $refKey));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deleteGroupStaticRef($callerContext, $refBase, $refKey)
	{
		if (!is_null(($groupHolder = $this->getGroupObjectRef($callerContext, $refBase, $refKey)))) {
			$this->deleteGroupStatic($groupHolder->getRole(), $groupHolder->getEntity()->getGroupId());
			return true;
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deleteGroupStatic($callerContext, $groupId)
	{
		$pollGroup = $this->getGroupObject($callerContext, $groupId);
		if (is_null($pollGroup))
			return false;
		(new \net\dryuf\comp\poll\sql\SqlPollGroupHandler($this, $pollGroup))->deleteGroup();
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	public function			getPollObject($callerContext, $pollId)
	{
		$objects = new \net\dryuf\util\LinkedList();
		if ($this->pollHeaderDao->listDynamic($objects, \net\dryuf\core\EntityHolder::createRoleOnly($callerContext), \net\dryuf\util\MapUtil::createStringNativeHashMap("pollId", $pollId), null, null, null) == 0)
			return null;
		return $objects->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	public function			getPollObjectRef($callerContext, $refBase, $refKey)
	{
		$objects = new \net\dryuf\util\LinkedList();
		if ($this->pollHeaderDao->listDynamic($objects, \net\dryuf\core\EntityHolder::createRoleOnly($callerContext), \net\dryuf\util\MapUtil::createStringNativeHashMap("refBase", $refBase, "refKey", $refKey), null, null, null) == 0)
			return null;
		return $objects->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\poll\PollHeader>')
	*/
	public function			getCreatePollObjectRef($callerContext, $refBase, $refKey)
	{
		if (is_null(($objectHolder = $this->getPollObjectRef($callerContext, $refBase, $refKey)))) {
			try {
				$header = new \net\dryuf\comp\poll\PollHeader();
				$header->setRefBase($refBase);
				$header->setRefKey($refKey);
				$this->pollHeaderDao->insert($header);
			}
			catch (\net\dryuf\dao\DaoUniqueConstraintException $ex) {
			}
			if (is_null(($objectHolder = $this->getPollObjectRef($callerContext, $refBase, $refKey)))) {
				throw new \net\dryuf\core\RuntimeException("failed to create poll object");
			}
		}
		return $objectHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHandler')
	*/
	public function			openCreatePollRef($callerContext, $refBase, $refKey)
	{
		return new \net\dryuf\comp\poll\sql\SqlPollHandler($this, $this->getCreatePollObjectRef($callerContext, $refBase, $refKey));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deletePollStatic($callerContext, $objectId)
	{
		$this->cleanPoll($objectId);
		$this->pollHeaderDao->removeByPk($objectId);
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanPoll($pollId)
	{
		$this->pollRecordDao->removeByCompos($pollId);
		$this->pollHeaderDao->updateStatistics($pollId);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deletePollStaticRef($callerContext, $refBase, $refKey)
	{
		if (!is_null(($objectHolder = $this->getPollObjectRef($callerContext, $refBase, $refKey)))) {
			$this->deletePollStatic($objectHolder->getRole(), $objectHolder->getEntity()->getPollId());
			return true;
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollGroupDao')
	@\javax\inject\Inject
	*/
	protected			$pollGroupDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollGroupDao')
	*/
	public function			getPollGroupDao()
	{
		return $this->pollGroupDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollHeaderDao')
	@\javax\inject\Inject
	*/
	protected			$pollHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollHeaderDao')
	*/
	public function			getPollHeaderDao()
	{
		return $this->pollHeaderDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollOptionDao')
	@\javax\inject\Inject
	*/
	protected			$pollOptionDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollOptionDao')
	*/
	public function			getPollOptionDao()
	{
		return $this->pollOptionDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollRecordDao')
	@\javax\inject\Inject
	*/
	protected			$pollRecordDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\dao\PollRecordDao')
	*/
	public function			getPollRecordDao()
	{
		return $this->pollRecordDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\time\TimeBo')
	@\javax\inject\Inject
	*/
	protected			$timeBo;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\time\TimeBo')
	*/
	public function			getTimeBo()
	{
		return $this->timeBo;
	}
};


?>
