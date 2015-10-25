<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class ImeiTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\ImeiTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("01234567890123", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("0123456 7890123", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("0123456 890123", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("0123456a890123", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("", null));
		\net\dryuf\tenv\DAssert::assertEquals("01234567890123", $this->textual->convert("01234567890123", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("01234567a890123", null);
	}
};


?>
