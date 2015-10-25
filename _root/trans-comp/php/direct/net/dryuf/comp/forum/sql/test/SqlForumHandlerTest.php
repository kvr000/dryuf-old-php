<?php

namespace net\dryuf\comp\forum\sql\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class SqlForumHandlerTest extends \net\dryuf\tenv\AppTenvObject
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			addForumComment($forumHandler, $comment)
	{
		$record = new \net\dryuf\comp\forum\ForumRecord();
		$record->setContent($comment);
		$forumHandler->addComment($record);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\sql\SqlForumHandler')
	*/
	public function			initForum($count)
	{
		$forumHandler = $this->getAppContainer()->createBeaned('net\dryuf\comp\forum\sql\SqlForumBo', null)->openCreateForumRef($this->createCallerContext(), \net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\forum\sql\test\SqlForumHandlerTest'), "test", "test");
		$forumHandler->cleanForum();
		for ($i = 0; $i < $count; $i++) {
			$this->addForumComment($forumHandler, "comment ".$i);
		}
		return $forumHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testContent()
	{
		$forumHandler = $this->initForum(2);
		$comments = new \net\dryuf\util\LinkedList();
		\net\dryuf\tenv\DAssert::assertEquals(2, $forumHandler->listComments($comments, 0, null));
		\net\dryuf\tenv\DAssert::assertEquals("comment 1", $comments->get(0)->getEntity()->getContent());
		\net\dryuf\tenv\DAssert::assertEquals("comment 0", $comments->get(1)->getEntity()->getContent());
	}
};


?>
