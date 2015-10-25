<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class LongTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\LongTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			testConvert()
	{
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("43f", null));
		\net\dryuf\tenv\DAssert::assertEquals(123, $this->textual->convert("123", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testFormat()
	{
		\net\dryuf\tenv\DAssert::assertEquals("123", $this->textual->format(123, null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIntegerException()
	{
		$this->textual->convert(".", null);
	}
};


?>
