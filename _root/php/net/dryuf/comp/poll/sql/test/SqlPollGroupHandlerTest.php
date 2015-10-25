<?php

namespace net\dryuf\comp\poll\sql\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class SqlPollGroupHandlerTest extends \net\dryuf\tenv\AppTenvObject implements \net\dryuf\core\AppContainerAware
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
	public function			afterAppContainer(\net\dryuf\core\AppContainer $appContainer)
	{
		parent::afterAppContainer($appContainer);
		$this->sqlPollBo = $appContainer->postProcessBean(new \net\dryuf\comp\poll\sql\SqlPollBo(), "pollBo", null);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\PollHandler')
	*/
	public function			initPoll($callerContext, $methodName)
	{
		$pollGroupHandler = $this->sqlPollBo->openCreateGroupRef($callerContext, 'net\dryuf\comp\poll\sql\test\SqlPollGroupHandlerTest', "test");
		if (!is_null(($pollHolder = $pollGroupHandler->getLastHeader()))) {
			$poll = $pollHolder->getEntity();
			$pollHandler = $pollGroupHandler->openPoll($poll->getPollId());
			$pollHandler->cleanPoll();
			$pollHandler->cleanOptions();
		}
		else {
			$poll = new \net\dryuf\comp\poll\PollHeader();
			$poll->setCreated(intval(microtime(true)*1000));
			$poll->setRefBase(\net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\poll\sql\test\SqlPollGroupHandlerTest'));
			$poll->setRefKey($methodName);
			$poll->setDescription("poll description");
			$pollHandler = $pollGroupHandler->createPoll($poll);
		}
		return $pollHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testHandler()
	{
		$pollHandler = $this->initPoll($this->createCallerContext(), "testHandler");
		$option = new \net\dryuf\comp\poll\PollOption();
		$option->setPollId($pollHandler->getPollDetail()->getPollId());
		$option->setOptionId(1);
		$option->setDescription("option 1");
		$this->sqlPollBo->getPollOptionDao()->insert($option);
		$option = new \net\dryuf\comp\poll\PollOption();
		$option->setPollId($pollHandler->getPollDetail()->getPollId());
		$option->setOptionId(2);
		$option->setDescription("option 2");
		$this->sqlPollBo->getPollOptionDao()->insert($option);
		$pollHandler->addPollVote(0, 1);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\poll\sql\SqlPollBo')
	*/
	protected			$sqlPollBo;
};


?>
