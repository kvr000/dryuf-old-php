<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class DateTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\DateTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testDate()
	{
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("12..2003", null));
		$valueDate = $this->textual->convert("12.3.1977", null);
		\net\dryuf\tenv\DAssert::assertEquals(226972800000, intval($valueDate));
		\net\dryuf\tenv\DAssert::assertEquals("12.03.1977", $this->textual->format(226972800000, null));
	}
};


?>
