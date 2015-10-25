<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class TimeIntervalTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\TimeIntervalTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("01:02:03", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("01:02:", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("01::02:03", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("01:02::03", null));
		\net\dryuf\tenv\DAssert::assertEquals(3723000, $this->textual->convert("01:02:03", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testConvertException()
	{
		$this->textual->convert("01::02:03", null);
	}
};


?>
