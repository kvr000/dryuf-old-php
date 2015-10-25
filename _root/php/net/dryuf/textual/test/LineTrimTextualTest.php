<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class LineTrimTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\LineTrimTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("abcd efg", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("abcd\nefg", null));
		\net\dryuf\tenv\DAssert::assertEquals("abcd efg", $this->textual->prepare(" abcd efg ", null));
		\net\dryuf\tenv\DAssert::assertEquals("abcd efg", $this->textual->convert("abcd efg", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("abcd\nefg", null);
	}
};


?>
