<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class BoolSwitchTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\BoolSwitchTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testBoolSwitch()
	{
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("truef", null));
		\net\dryuf\tenv\DAssert::assertEquals(true, $this->textual->convert("true", null));
		\net\dryuf\tenv\DAssert::assertEquals(false, $this->textual->convert("false", null));
		\net\dryuf\tenv\DAssert::assertEquals(false, $this->textual->convert("0", null));
		\net\dryuf\tenv\DAssert::assertEquals("true", $this->textual->format(true, null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testBoolSwitchException()
	{
		$this->textual->convert(".", null);
	}
};


?>
