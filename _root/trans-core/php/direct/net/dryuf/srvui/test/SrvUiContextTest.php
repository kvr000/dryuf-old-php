<?php

namespace net\dryuf\srvui\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class SrvUiContextTest extends \net\dryuf\tenv\AppTenvObject
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testLocalize()
	{
		$uiContext = $this->createCallerContext()->getUiContext();
		$uiContext->setLanguage("en");
		\net\dryuf\tenv\DAssert::assertEquals("some replace text", $uiContext->localizeArgs("", "some {0} text", array( "replace" )));
	}
};


?>
