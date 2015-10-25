<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class LongitudeTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\LongitudeTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("E 1°2'34.567\"", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("E °2'34.567\"", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("E 1°'34.567\"", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("E 1°24.567\"", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("E 1°2'3.567", null));
		\net\dryuf\tenv\DAssert::assertEquals(10429352, $this->textual->convert("E 1°2'34.567\"", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("E 1°'34.567\"", null);
	}
};


?>
