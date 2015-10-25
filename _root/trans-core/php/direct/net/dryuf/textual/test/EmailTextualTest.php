<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class EmailTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\EmailTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("null@dev.org", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("null @dev.org", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("null@ dev.org", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("null@dev..org", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("", null));
		\net\dryuf\tenv\DAssert::assertEquals("null@dev.org", $this->textual->convert("null@dev.org", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("null @dev.org", null);
	}
};


?>
