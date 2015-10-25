<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class UuidTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\UuidTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("01234567-0123-0123-0123-456789abcdef", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("01234567-0123-012-0123-456789abcdef", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("01234567-012-0123-0123-456789abcdef", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("0123456-0123-0123-0123-456789abcdef", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("01234567-0123-0123-0123-456789abcde", null));
		\net\dryuf\tenv\DAssert::assertEquals("01234567-0123-0123-0123-456789abcdef", $this->textual->convert("01234567-0123-0123-0123-456789abcdef", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("01234567-0123-0123-0123-456789abcdef0", null);
	}
};


?>
