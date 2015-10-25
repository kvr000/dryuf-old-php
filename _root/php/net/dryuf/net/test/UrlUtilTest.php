<?php

namespace net\dryuf\net\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class UrlUtilTest extends \net\dryuf\core\Object
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
	public function			encodeUrlTest()
	{
		\net\dryuf\tenv\DAssert::assertEquals("path+%3F%26%2Fend", \net\dryuf\net\util\UrlUtil::encodeUrl("path ?&/end"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			appendQueryTest()
	{
		\net\dryuf\tenv\DAssert::assertEquals("http://localhost/?par0=value0", \net\dryuf\net\util\UrlUtil::appendQuery("http://localhost/", "par0=value0"));
		\net\dryuf\tenv\DAssert::assertEquals("http://localhost/?p=v&par1=value1", \net\dryuf\net\util\UrlUtil::appendQuery("http://localhost/?p=v", "par1=value1"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			appendParameterTest()
	{
		\net\dryuf\tenv\DAssert::assertEquals("http://localhost/?par0=value0", \net\dryuf\net\util\UrlUtil::appendParameter("http://localhost/", "par0", "value0"));
		\net\dryuf\tenv\DAssert::assertEquals("http://localhost/?par1=%3F%26%3D", \net\dryuf\net\util\UrlUtil::appendParameter("http://localhost/", "par1", "?&="));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			buildQueryStringTest()
	{
		\net\dryuf\tenv\DAssert::assertEquals("par0=value0&par1=%3F%26%3D", \net\dryuf\net\util\UrlUtil::buildQueryString(\net\dryuf\util\MapUtil::createStringNativeHashMap("par0", "value0", "par1", "?&=")));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			getReversePathTest()
	{
		\net\dryuf\tenv\DAssert::assertEquals("../", \net\dryuf\net\util\UrlUtil::getReversePath("abcd/"));
		\net\dryuf\tenv\DAssert::assertEquals("../../", \net\dryuf\net\util\UrlUtil::getReversePath("abcd/xyz/"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			truncateToDirTest()
	{
		\net\dryuf\tenv\DAssert::assertEquals("abcd/", \net\dryuf\net\util\UrlUtil::truncateToDir("abcd/"));
		\net\dryuf\tenv\DAssert::assertEquals("abcd/", \net\dryuf\net\util\UrlUtil::truncateToDir("abcd/ab"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			truncateToParentTest()
	{
		\net\dryuf\tenv\DAssert::assertEquals("/", \net\dryuf\net\util\UrlUtil::truncateToParent("/abcd/"));
		\net\dryuf\tenv\DAssert::assertEquals("/", \net\dryuf\net\util\UrlUtil::truncateToParent("/abcd/ab"));
		\net\dryuf\tenv\DAssert::assertEquals("abcd/", \net\dryuf\net\util\UrlUtil::truncateToParent("abcd/ab/"));
		\net\dryuf\tenv\DAssert::assertEquals("abcd/", \net\dryuf\net\util\UrlUtil::truncateToParent("abcd/ab/xyz"));
	}
};


?>
