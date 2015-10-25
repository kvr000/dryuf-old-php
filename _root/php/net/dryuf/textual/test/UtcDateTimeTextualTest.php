<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class UtcDateTimeTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\UtcDateTimeTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testDateTime()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("12.03.1977 01:02:03", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("12.03.197701:02:03", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("12.03.1977 0102:03", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("1203.1977 01:02:03", null));
		\net\dryuf\tenv\DAssert::assertEquals(226976523000, $this->textual->convert("12.03.1977 01:02:03", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testDateTimeException()
	{
		$this->textual->convert("12.03.197701:02:03", null);
	}
};


?>
