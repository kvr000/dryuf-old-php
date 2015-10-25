<?php

namespace net\dryuf\time\util\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class DateTimeUtilTest extends \net\dryuf\tenv\AppTenvObject
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
	public function			testFormatUtc()
	{
		\net\dryuf\tenv\DAssert::assertEquals("1977-03-12 06:07:08 UTC", \net\dryuf\time\util\DateTimeUtil::formatUtcReadable(226994828000));
		\net\dryuf\tenv\DAssert::assertEquals("1977-03-12T06:07:08Z", \net\dryuf\time\util\DateTimeUtil::formatUtcIso(226994828000));
	}
};


?>
