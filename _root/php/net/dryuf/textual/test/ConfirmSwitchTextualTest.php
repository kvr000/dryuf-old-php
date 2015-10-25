<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class ConfirmSwitchTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\ConfirmSwitchTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testConfirmSwitch()
	{
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("truef", null));
		\net\dryuf\tenv\DAssert::assertEquals(true, $this->textual->convert("true", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("false", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testConfirmSwitchException()
	{
		$this->textual->convert(".", null);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testConfirmSwitchFalse()
	{
		$this->textual->convert("false", null);
	}
};


?>
