<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class FileTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\FileTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("somefile.txt", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("/path", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("path/", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("..", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check(".", null));
		\net\dryuf\tenv\DAssert::assertEquals("somefile.txt", $this->textual->convert("somefile.txt", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert("/path", null);
	}
};


?>
