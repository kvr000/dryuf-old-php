<?php

namespace net\dryuf\comp\forum\sql;


class SqlForumBo extends \net\dryuf\core\Object implements \net\dryuf\comp\forum\bo\ForumBo
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\forum\ForumHeader>')
	*/
	public function			getForumObjectRef($callerContext, $refBase, $refKey)
	{
		$headers = new \net\dryuf\util\LinkedList();
		if ($this->forumHeaderDao->listDynamic($headers, \net\dryuf\core\EntityHolder::createRoleOnly($callerContext), \net\dryuf\util\MapUtil::createStringNativeHashMap("refBase", $refBase, "refKey", $refKey), null, null, null) == 0)
			return null;
		return $headers->get(0);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\forum\ForumHeader>')
	*/
	public function			getCreateForumObjectRef($callerContext, $refBase, $refKey, $label)
	{
		if (is_null(($forumHolder = $this->getForumObjectRef($callerContext, $refBase, $refKey)))) {
			try {
				$header = new \net\dryuf\comp\forum\ForumHeader();
				$header->setRefBase($refBase);
				$header->setRefKey($refKey);
				$header->setLabel($label);
				$this->forumHeaderDao->insert($header);
			}
			catch (\net\dryuf\dao\DaoUniqueConstraintException $ex) {
			}
			if (is_null(($forumHolder = $this->getForumObjectRef($callerContext, $refBase, $refKey)))) {
				throw new \net\dryuf\core\RuntimeException("failed to create forum object");
			}
		}
		return $forumHolder;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumHandler')
	*/
	public function			openCreateForumRef($callerContext, $refBase, $refKey, $label)
	{
		return new \net\dryuf\comp\forum\sql\SqlForumHandler($this, $this->getCreateForumObjectRef($callerContext, $refBase, $refKey, $label));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			deleteStaticRef($callerContext, $refBase, $refKey)
	{
		if (!is_null(($forumHolder = $this->getForumObjectRef($callerContext, $refBase, $refKey)))) {
			$this->deleteForum($forumHolder->getEntity()->getForumId());
			return true;
		}
		return false;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			deleteForum($forumId)
	{
		$this->cleanForum($forumId);
		$this->forumHeaderDao->removeByPk($forumId);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanForum($forumId)
	{
		$this->forumRecordDao->removeByCompos($forumId);
		$this->updateForumHeader($forumId);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			updateForumHeader($forumId)
	{
		$this->forumHeaderDao->updateRecordStats($forumId);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\dao\ForumHeaderDao')
	*/
	public function			getForumHeaderDao()
	{
		return $this->forumHeaderDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\dao\ForumRecordDao')
	*/
	public function			getForumRecordDao()
	{
		return $this->forumRecordDao;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\dao\ForumHeaderDao')
	@\javax\inject\Inject
	*/
	protected			$forumHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\dao\ForumRecordDao')
	@\javax\inject\Inject
	*/
	protected			$forumRecordDao;
};


?>
