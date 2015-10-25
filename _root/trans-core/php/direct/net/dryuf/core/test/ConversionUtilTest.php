<?php

namespace net\dryuf\core\test;


class ConversionUtilTest extends \net\dryuf\core\Object
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
	public function			testConversions()
	{
		\net\dryuf\tenv\DAssert::assertEquals(false, \net\dryuf\core\ConversionUtil::convertToClass('boolean', 0));
		\net\dryuf\tenv\DAssert::assertEquals(true, \net\dryuf\core\ConversionUtil::convertToClass('boolean', 1));
		\net\dryuf\tenv\DAssert::assertEquals(false, \net\dryuf\core\ConversionUtil::convertToClass('boolean', false));
		\net\dryuf\tenv\DAssert::assertEquals(true, \net\dryuf\core\ConversionUtil::convertToClass('boolean', true));
		\net\dryuf\tenv\DAssert::assertEquals(intval(10), \net\dryuf\core\ConversionUtil::convertToClass('int', 10));
		\net\dryuf\tenv\DAssert::assertEquals(intval(10), \net\dryuf\core\ConversionUtil::convertToClass('int', 10.0));
		\net\dryuf\tenv\DAssert::assertEquals(intval(10), \net\dryuf\core\ConversionUtil::convertToClass('long', 10));
		\net\dryuf\tenv\DAssert::assertEquals(intval(10), \net\dryuf\core\ConversionUtil::convertToClass('long', 10.0));
		\net\dryuf\tenv\DAssert::assertEquals(doubleval(10), \net\dryuf\core\ConversionUtil::convertToClass('double', 10));
		\net\dryuf\tenv\DAssert::assertEquals(doubleval(10), \net\dryuf\core\ConversionUtil::convertToClass('double', 10.0));
	}
};


?>
