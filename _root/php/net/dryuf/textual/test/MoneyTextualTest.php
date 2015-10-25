<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class MoneyTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\MoneyTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("123.456", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("123 .456", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("123. 456", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("123..456", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check(".123.456", null));
		\net\dryuf\tenv\DAssert::assertEqualsPercent1(123.456, $this->textual->convert("123.456", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testFormat()
	{
		\net\dryuf\tenv\DAssert::assertEquals("123.456", $this->textual->format(123.4561, null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("123 .456", null);
	}
};


?>
