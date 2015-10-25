<?php

namespace net\dryuf\text\markdown\test;


class NewLineMarkdownServiceTest extends \net\dryuf\core\Object
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
		$markdownService = new \net\dryuf\text\markdown\NewLineMarkdownService();
		\net\dryuf\tenv\DAssert::assertEquals("Hello<br/>\nworld", trim($markdownService->convertToXhtml("Hello\nworld\n")));
	}
};


?>
