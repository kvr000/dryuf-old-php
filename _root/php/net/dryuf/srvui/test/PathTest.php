<?php

namespace net\dryuf\srvui\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class PathTest extends \net\dryuf\tenv\AppTenvObject
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\srvui\PageContext')
	*/
	public function			createPageContext($path)
	{
		$testRequest = new \net\dryuf\srvui\DummyRequest();
		$testRequest->setPath($path);
		$pageContext = new \net\dryuf\srvui\DefaultPageContext($this->createCallerContext(), $testRequest);
		return $pageContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testRoot()
	{
		$pageContext = $this->createPageContext("/");
		\net\dryuf\tenv\DAssert::assertNull($pageContext->getPathElement());
		\net\dryuf\tenv\DAssert::assertEquals("", $pageContext->getCurrentPath());
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(true));
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(true));
		\net\dryuf\tenv\DAssert::assertTrue($pageContext->needPathFinal());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testFile()
	{
		$pageContext = $this->createPageContext("/file.html");
		\net\dryuf\tenv\DAssert::assertEquals("file.html", $pageContext->getPathElement());
		\net\dryuf\tenv\DAssert::assertEquals("file.html", $pageContext->getCurrentPath());
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(false));
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(false));
		\net\dryuf\tenv\DAssert::assertNull($pageContext->getPathElement());
		\net\dryuf\tenv\DAssert::assertNull($pageContext->getRedirected());
		\net\dryuf\tenv\DAssert::assertTrue($pageContext->needPathFinal());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testDir()
	{
		$pageContext = $this->createPageContext("/dir/");
		\net\dryuf\tenv\DAssert::assertEquals("dir", $pageContext->getPathElement());
		\net\dryuf\tenv\DAssert::assertEquals("dir/", $pageContext->getCurrentPath());
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(true));
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(true));
		\net\dryuf\tenv\DAssert::assertNull($pageContext->getPathElement());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testMultiPath()
	{
		$pageContext = $this->createPageContext("/dir/file.html");
		\net\dryuf\tenv\DAssert::assertEquals("dir", $pageContext->getPathElement());
		\net\dryuf\tenv\DAssert::assertEquals("dir/", $pageContext->getCurrentPath());
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(true));
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(true));
		\net\dryuf\tenv\DAssert::assertEquals("file.html", $pageContext->getPathElement());
		\net\dryuf\tenv\DAssert::assertEquals("dir/file.html", $pageContext->getCurrentPath());
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(false));
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->needPathSlash(false));
		\net\dryuf\tenv\DAssert::assertNull($pageContext->getResponse()->getRedirected());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testFileSlash()
	{
		$pageContext = $this->createPageContext("/file.html/");
		\net\dryuf\tenv\DAssert::assertEquals("file.html", $pageContext->getPathElement());
		\net\dryuf\tenv\DAssert::assertEquals("file.html/", $pageContext->getCurrentPath());
		\net\dryuf\tenv\DAssert::assertFalse($pageContext->needPathSlash(false));
		\net\dryuf\tenv\DAssert::assertFalse($pageContext->needPathSlash(false));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testDirNoSlash()
	{
		$pageContext = $this->createPageContext("/dir");
		\net\dryuf\tenv\DAssert::assertEquals("dir", $pageContext->getPathElement());
		\net\dryuf\tenv\DAssert::assertEquals("dir", $pageContext->getCurrentPath());
		\net\dryuf\tenv\DAssert::assertFalse($pageContext->needPathSlash(true));
		\net\dryuf\tenv\DAssert::assertFalse($pageContext->needPathSlash(true));
		\net\dryuf\tenv\DAssert::assertNotNull($pageContext->getResponse()->getRedirected());
	}
};


?>
