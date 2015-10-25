<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class Hex64TextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\Hex64Textual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("0123456789ABCDEF", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("012 3456789ABCDEF", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check(".0123456789ABCDEF", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("0123456789ABCDEF.", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("0123.456789ABCDEF", null));
		\net\dryuf\tenv\DAssert::assertEquals("0123456789ABCDEF", $this->textual->convert("0123456789ABCDEF", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("0123456789AB CDEF", null);
	}
};


?>
