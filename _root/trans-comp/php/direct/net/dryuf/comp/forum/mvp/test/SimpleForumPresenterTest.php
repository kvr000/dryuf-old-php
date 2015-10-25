<?php

namespace net\dryuf\comp\forum\mvp\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class SimpleForumPresenterTest extends \net\dryuf\mvp\tenv\PresenterTenvObject
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\Presenter')
	*/
	public function			initPresenter($parentPresenter)
	{
		$forumHandler = $this->forumBo->openCreateForumRef($parentPresenter->getCallerContext(), 'net\dryuf\comp\forum\mvp\test\SimpleForumPresenterTest', "test", "test");
		return new \net\dryuf\comp\forum\mvp\SimpleForumPresenter($parentPresenter, \net\dryuf\core\Options::$NONE, $forumHandler);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testPresenter()
	{
		\net\dryuf\tenv\DAssert::assertNotEquals(-1, \net\dryuf\core\StringUtil::indexOf($this->runGetString($this->initPresenter($this->createRootPresenter())), "class="));
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\forum\bo\ForumBo')
	@\javax\inject\Inject
	*/
	protected			$forumBo;
};


?>
