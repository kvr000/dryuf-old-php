<?php

namespace net\dryuf\core\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class InjectionTest extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			InjectionTest()
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testAppContainerAware()
	{
		\net\dryuf\tenv\DAssert::assertNotNull($this->testBean->getAppContainer());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testInjectMethod()
	{
		\net\dryuf\tenv\DAssert::assertNotNull($this->testBean->getMimeTypeService());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testInjectField()
	{
		\net\dryuf\tenv\DAssert::assertNotNull($this->testBean->getLoggerService());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testParamMethod()
	{
		\net\dryuf\tenv\DAssert::assertTrue($this->testBean->getTimeBo());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testParamField()
	{
		\net\dryuf\tenv\DAssert::assertNotNull($this->testBean->getCaptchaService());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\test\TestBean')
	@\javax\inject\Inject
	*/
	protected			$testBean;
};


?>
