<?php

namespace net\dryuf\comp\forum\sql;


class SqlForumHandler extends \net\dryuf\comp\forum\GenericForumHandler
{
	/**
	*/
	function			__construct($sqlForumBo, $forumHeaderHolder)
	{
		parent::__construct($forumHeaderHolder->getRole());
		$this->sqlForumBo = $sqlForumBo;
		$this->callerContext = $forumHeaderHolder->getRole();
		$forumHeader = $forumHeaderHolder->getEntity();
		$this->forumHeaderHolder = $forumHeaderHolder;
		$this->forumHeader = $forumHeader;
		$this->forumHeaderDao = $sqlForumBo->getForumHeaderDao();
		$this->forumRecordDao = $sqlForumBo->getForumRecordDao();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			listComments($comments, $start, $limit)
	{
		return $this->forumRecordDao->listDynamic($comments, $this->forumHeaderHolder, null, null, $start, $limit);
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			addComment($forumRecord)
	{
		$forumRecord->setForumId($this->forumHeader->getForumId());
		$forumRecord->setCreated(intval(microtime(true)*1000));
		for (;;) {
			$counter = $this->forumHeaderDao->getMaxCounter($this->forumHeader->getForumId());
			if (is_null($counter))
				$counter = 0;
			$forumRecord->setCounter($counter+1);
			try {
				$this->forumRecordDao->insertTxNew($forumRecord);
				$this->sqlForumBo->updateForumHeader($this->forumHeader->getForumId());
				;
				return $forumRecord->getPk()->getCounter();
			}
			catch (\net\dryuf\dao\DaoPrimaryKeyConstraintException $ex) {
				continue;
			}
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\forum\ForumRecord>')
	*/
	public function			loadComment($counter)
	{
		return $this->forumRecordDao->retrieveDynamic($this->forumHeaderHolder, new \net\dryuf\comp\forum\ForumRecord\Pk($this->forumHeader->getForumId(), $counter));
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			updateComment($counter, $content)
	{
		if (is_null(($forumRecordHolder = $this->loadComment($counter))))
			return false;
		$this->forumRecordDao->updateDynamic($forumRecordHolder, $forumRecordHolder->getEntity()->getPk(), \net\dryuf\util\MapUtil::createStringNativeHashMap("content", $content, "lastEdit", intval(microtime(true)*1000)));
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanForum()
	{
		$this->forumRecordDao->removeByCompos($this->forumHeader->getForumId());
	}

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
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\sql\SqlForumBo')
	*/
	protected			$sqlForumBo;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\dao\ForumHeaderDao')
	*/
	protected			$forumHeaderDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\dao\ForumRecordDao')
	*/
	protected			$forumRecordDao;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\ForumHeader')
	*/
	protected			$forumHeader;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<net\dryuf\comp\forum\ForumHeader>')
	*/
	protected			$forumHeaderHolder;
};


?>
