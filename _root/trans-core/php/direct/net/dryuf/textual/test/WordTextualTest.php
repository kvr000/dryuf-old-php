<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class WordTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\WordTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("hello", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("hello world", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check(" hello", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("hello ", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("hello/world", null));
		\net\dryuf\tenv\DAssert::assertEquals("hello", $this->textual->convert("hello", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testFormat()
	{
		\net\dryuf\tenv\DAssert::assertEquals("hello", $this->textual->format("hello", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("hello world", null);
	}
};


?>
