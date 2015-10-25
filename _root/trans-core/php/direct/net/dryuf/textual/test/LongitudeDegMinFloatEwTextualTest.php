<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class LongitudeDegMinFloatEwTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\LongitudeDegMinFloatEwTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testFormat()
	{
		\net\dryuf\tenv\DAssert::assertEquals("123 27.407 E", $this->textual->format(1234567890, null));
	}
};


?>
