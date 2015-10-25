<?php

namespace net\dryuf\text\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class TextUtilTest extends \net\dryuf\core\Object
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
	public function			transliterateTest()
	{
		\net\dryuf\tenv\DAssert::assertEquals("zlutoucky kun upel dabelske ody", \net\dryuf\text\util\TextUtil::transliterate("žluťoučký kůň úpěl ďábelské ódy"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			convertNameToDisplayTest()
	{
		\net\dryuf\tenv\DAssert::assertEquals("zlutoucky-kun-upel-dabelske-ody", \net\dryuf\text\util\TextUtil::convertNameToDisplay(" žluťoučký kůň  úpěl ďábelské ódy "));
	}
};


?>
