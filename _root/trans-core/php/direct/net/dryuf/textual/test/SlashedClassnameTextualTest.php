<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class SlashedClassnameTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\SlashedClassnameTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("net/dryuf/textual/DotClassname", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("net/dryuf/textual//DotClassname", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("net/dryuf/textual/DotClassname.", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("/net/dryuf/textual/DotClassname", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("net/dryuf/textual/Dot Classname", null));
		\net\dryuf\tenv\DAssert::assertEquals("net/dryuf/textual/DotClassname", $this->textual->convert("net/dryuf/textual/DotClassname", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("net/dryuf/textual/Dot Classname", null);
	}
};


?>
