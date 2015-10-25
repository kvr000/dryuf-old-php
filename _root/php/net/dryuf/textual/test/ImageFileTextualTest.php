<?php

namespace net\dryuf\textual\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class ImageFileTextualTest extends \net\dryuf\textual\test\TextualsTestBase
{
	/**
	*/
	function			__construct()
	{
		parent::__construct('net\dryuf\textual\ImageFileTextual');
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testCorrect()
	{
		\net\dryuf\tenv\DAssert::assertNull($this->textual->check("abc.jpeg", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("a/bc.jpeg", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("abc.jpegf", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check(".jpeg/", null));
		\net\dryuf\tenv\DAssert::assertNotNull($this->textual->check("", null));
		\net\dryuf\tenv\DAssert::assertEquals("abc.jpeg", $this->textual->convert("abc.jpeg", null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test(expected = 'net\dryuf\core\Exception')
	*/
	public function			testIncorrectException()
	{
		$this->textual->convert(".jpeg", null);
	}
};


?>
