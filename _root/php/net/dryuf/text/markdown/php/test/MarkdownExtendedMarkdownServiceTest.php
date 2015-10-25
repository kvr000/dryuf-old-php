<?php

namespace net\dryuf\text\markdown\php\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:applicationContext.xml")
*/
class MarkdownExtendedMarkdownServiceTest extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testConvertToXhtml()
	{
		$markdownService = new \net\dryuf\text\markdown\php\MarkdownExtendedMarkdownService();
		\net\dryuf\tenv\DAssert::assertEquals("<h1 id=\"hello\">Hello</h1>", trim($markdownService->convertToXhtml("# Hello\n")));
	}
};


?>
