<?php

namespace net\dryuf\process\command\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class GetOptionsStdTest extends \net\dryuf\tenv\AppTenvObject
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
	public function			testWrongIndicator()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("i", null));
		\net\dryuf\tenv\DAssert::assertNotNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "-v" )));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testRequiredValue()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("f", 'net\dryuf\textual\LongTextual'));
		\net\dryuf\tenv\DAssert::assertNotNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "-f" )));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testUnexpectedParameter()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("i", null));
		\net\dryuf\tenv\DAssert::assertNotNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "-i", "parameter" )));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testMandatories()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("n", 'net\dryuf\textual\IntegerTextual'))->setMandatories(\net\dryuf\util\CollectionUtil::createStringNativeHashSet("n"));
		\net\dryuf\tenv\DAssert::assertNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "-n", "20" )));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testUnsatisfiedMandatories()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("n", 'net\dryuf\textual\IntegerTextual', "i", null))->setMandatories(\net\dryuf\util\CollectionUtil::createStringNativeHashSet("n"));
		\net\dryuf\tenv\DAssert::assertNotNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "-i" )));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testIndicator()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("i", null));
		\net\dryuf\tenv\DAssert::assertNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "-i" )));
		\net\dryuf\tenv\DAssert::assertTrue($options->get("i"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testTextual()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("n", 'net\dryuf\textual\IntegerTextual'));
		\net\dryuf\tenv\DAssert::assertNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "-n", "20" )));
		\net\dryuf\tenv\DAssert::assertEquals(20, $options->get("n"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testWrongTextual()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("n", 'net\dryuf\textual\IntegerTextual'));
		\net\dryuf\tenv\DAssert::assertNotNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "-n", "a" )));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testParameter()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("n", 'net\dryuf\textual\IntegerTextual'))->setMaxParameters(1);
		\net\dryuf\tenv\DAssert::assertNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "param1" )));
		\net\dryuf\tenv\DAssert::assertEquals(1, count($options->get("")));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testMultiParameters()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("n", 'net\dryuf\textual\IntegerTextual'))->setMaxParameters(2);
		\net\dryuf\tenv\DAssert::assertNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "-n", "1", "param1", "param2" )));
		\net\dryuf\tenv\DAssert::assertEquals(2, count($options->get("")));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testOptionEnd()
	{
		$options = new \net\dryuf\util\php\StringNativeHashMap();
		$getOpt = (new \net\dryuf\process\command\GetOptionsStd())->setDefinition(\net\dryuf\util\MapUtil::createStringNativeHashMap("n", 'net\dryuf\textual\IntegerTextual'))->setMaxParameters(4);
		\net\dryuf\tenv\DAssert::assertNull($getOpt->parseArguments($this->createCallerContext(), $options, array( "--", "-n", "1" )));
		\net\dryuf\tenv\DAssert::assertEquals(2, count($options->get("")));
	}
};


?>
