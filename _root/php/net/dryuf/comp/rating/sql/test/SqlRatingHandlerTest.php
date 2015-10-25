<?php

namespace net\dryuf\comp\rating\sql\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class SqlRatingHandlerTest extends \net\dryuf\tenv\AppTenvObject implements \net\dryuf\core\AppContainerAware
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
		$this->sqlRatingBo = $appContainer->postProcessBean(new \net\dryuf\comp\rating\sql\SqlRatingBo(), "sqlRatingBo", null);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\RatingHandler')
	*/
	public function			initRating($callerContext, $methodName)
	{
		$ratingHandler = $this->sqlRatingBo->openCreateRatingRef($callerContext, \net\dryuf\core\Dryuf::dotClassname('net\dryuf\comp\rating\sql\test\SqlRatingHandlerTest'), $methodName, 5);
		$ratingHandler->cleanRating();
		return $ratingHandler;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testHandler()
	{
		$ratingHandler = $this->initRating($this->createCallerContext(), "testHandler");
		$ratingHandler->refresh();
		\net\dryuf\tenv\DAssert::assertEquals(0, $ratingHandler->getRatingDetail()->getRating());
		$ratingHandler->addRating(1, 1);
		$ratingHandler->refresh();
		\net\dryuf\tenv\DAssert::assertEquals(1, $ratingHandler->getRatingDetail()->getRating());
		$ratingHandler->addRating(2, 5);
		$ratingHandler->refresh();
		\net\dryuf\tenv\DAssert::assertEquals(3, $ratingHandler->getRatingDetail()->getRating());
		$ratingHandler->addRating(1, 3);
		$ratingHandler->refresh();
		\net\dryuf\tenv\DAssert::assertEquals(4, $ratingHandler->getRatingDetail()->getRating());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\rating\sql\SqlRatingBo')
	*/
	protected			$sqlRatingBo;
};


?>
