<?php

namespace net\dryuf\app\test;


/**
@\org\junit\runner\RunWith(value = 'org\springframework\test\context\junit4\SpringJUnit4ClassRunner')
@\org\springframework\test\context\ContextConfiguration(value = "classpath:testContext.xml")
*/
class ClassMetaJavaTest extends \net\dryuf\tenv\AppTenvObject
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
	public function			testTestMain()
	{
		$meta = \net\dryuf\app\ClassMetaJava::openCached($this->createCallerContext()->getAppContainer(), 'net\dryuf\tenv\TestMain', null);
		\net\dryuf\tenv\DAssert::assertNotNull($meta, "meta not created");
		\net\dryuf\tenv\DAssert::assertEquals('net\dryuf\tenv\TestMain', $meta->getDataClass());
		\net\dryuf\tenv\DAssert::assertEquals('net\dryuf\tenv\TestMain', $meta->getDataClassName());
		\net\dryuf\tenv\DAssert::assertEquals(false, $meta->isPkEmbedded());
		\net\dryuf\tenv\DAssert::assertEquals('integer', $meta->getPkClass());
		\net\dryuf\tenv\DAssert::assertEquals(false, $meta->isPkEmbedded());
		\net\dryuf\tenv\DAssert::assertEquals("testId", $meta->getPkName());
		\net\dryuf\tenv\DAssert::assertNull($meta->getComposPath(), "");
		\net\dryuf\tenv\DAssert::assertNull($meta->getComposPkClass());
		\net\dryuf\tenv\DAssert::assertEquals(0, count($meta->getAdditionalPkFields()));
		\net\dryuf\tenv\DAssert::assertEquals(4, count($meta->getFields()));
		\net\dryuf\tenv\DAssert::assertEquals("testId", $meta->getFields()[0]->getName());
		\net\dryuf\tenv\DAssert::assertEquals("name", $meta->getFields()[1]->getName());
		\net\dryuf\tenv\DAssert::assertEquals("svalue", $meta->getFields()[2]->getName());
		\net\dryuf\tenv\DAssert::assertEquals("ivalue", $meta->getFields()[3]->getName());
		\net\dryuf\tenv\DAssert::assertEquals("testId", $meta->getRefName());
		\net\dryuf\tenv\DAssert::assertEquals(1, count($meta->getDisplayKeys()));
		\net\dryuf\tenv\DAssert::assertEquals("testId", $meta->getDisplayKeys()[0]);
		\net\dryuf\tenv\DAssert::assertEquals("testId", $meta->getField("testId")->getName());
		\net\dryuf\tenv\DAssert::assertEquals("ivalue", $meta->getField("ivalue")->getName());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testTestMainAccess()
	{
		$testMain = new \net\dryuf\tenv\TestMain();
		$testMain->setPk(6);
		$testMain->setIvalue(10);
		$testMain->setSvalue("str");
		$meta = \net\dryuf\app\ClassMetaJava::openCached($this->createCallerContext()->getAppContainer(), 'net\dryuf\tenv\TestMain', null);
		\net\dryuf\tenv\DAssert::assertEquals(6, $meta->getEntityPkValue($testMain));
		\net\dryuf\tenv\DAssert::assertEquals(10, $meta->getEntityFieldValue($testMain, "ivalue"));
		\net\dryuf\tenv\DAssert::assertEquals("str", $meta->getEntityFieldValue($testMain, "svalue"));
		\net\dryuf\tenv\DAssert::assertEquals("6/", $meta->urlDisplayKey($this->createCallerContext(), $testMain));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testTestChild()
	{
		$meta = \net\dryuf\app\ClassMetaJava::openCached($this->createCallerContext()->getAppContainer(), 'net\dryuf\tenv\TestChild', null);
		\net\dryuf\tenv\DAssert::assertNotNull($meta, "meta not created");
		\net\dryuf\tenv\DAssert::assertEquals('net\dryuf\tenv\TestChild', $meta->getDataClass());
		\net\dryuf\tenv\DAssert::assertEquals('net\dryuf\tenv\TestChild', $meta->getDataClassName());
		\net\dryuf\tenv\DAssert::assertEquals(true, $meta->isPkEmbedded());
		\net\dryuf\tenv\DAssert::assertEquals('net\dryuf\tenv\TestChild\Pk', $meta->getPkClass());
		\net\dryuf\tenv\DAssert::assertEquals(true, $meta->isPkEmbedded());
		\net\dryuf\tenv\DAssert::assertEquals("pk", $meta->getPkName());
		\net\dryuf\tenv\DAssert::assertEquals("pk.testId", $meta->getComposPath());
		\net\dryuf\tenv\DAssert::assertEquals(\net\dryuf\app\FieldDef::AST_Compos, $meta->getPathField("pk.testId")->getAssocType());
		\net\dryuf\tenv\DAssert::assertEquals('net\dryuf\tenv\TestMain', $meta->getPathField("pk.testId")->getAssocClass());
		\net\dryuf\tenv\DAssert::assertEquals('integer', $meta->getComposPkClass());
		\net\dryuf\tenv\DAssert::assertEquals(1, count($meta->getAdditionalPkFields()));
		\net\dryuf\tenv\DAssert::assertEquals(1, count($meta->getAdditionalPkFields()));
		\net\dryuf\tenv\DAssert::assertEquals(2, count($meta->getFields()));
		\net\dryuf\tenv\DAssert::assertEquals("pk", $meta->getFields()[0]->getName());
		\net\dryuf\tenv\DAssert::assertEquals("svalue", $meta->getFields()[1]->getName());
		\net\dryuf\tenv\DAssert::assertEquals("pk", $meta->getRefName());
		\net\dryuf\tenv\DAssert::assertEquals(1, count($meta->getDisplayKeys()));
		\net\dryuf\tenv\DAssert::assertEquals("pk.childId", $meta->getDisplayKeys()[0]);
		\net\dryuf\tenv\DAssert::assertEquals("pk", $meta->getField("pk")->getName());
		\net\dryuf\tenv\DAssert::assertEquals("svalue", $meta->getField("svalue")->getName());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testTestChildAccess()
	{
		$testChild = new \net\dryuf\tenv\TestChild();
		$testChild->setPk(new \net\dryuf\tenv\TestChild\Pk(6, 16));
		$testChild->setSvalue("str");
		$meta = \net\dryuf\app\ClassMetaJava::openCached($this->getAppContainer(), 'net\dryuf\tenv\TestChild', null);
		\net\dryuf\tenv\DAssert::assertEquals(new \net\dryuf\tenv\TestChild\Pk(6, 16), $meta->getEntityPkValue($testChild));
		\net\dryuf\tenv\DAssert::assertEquals("str", $meta->getEntityFieldValue($testChild, "svalue"));
		\net\dryuf\tenv\DAssert::assertEquals(6, $meta->getEntityPathValue($testChild, "pk.testId"));
		\net\dryuf\tenv\DAssert::assertEquals(16, $meta->getEntityPathValue($testChild, "pk.childId"));
		\net\dryuf\tenv\DAssert::assertEquals("str", $meta->getEntityPathValue($testChild, "svalue"));
		\net\dryuf\tenv\DAssert::assertEquals("16/", $meta->urlDisplayKey($this->createCallerContext(), $testChild));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testReferenceDef()
	{
		$meta = \net\dryuf\app\ClassMetaJava::openCached($this->createCallerContext()->getAppContainer(), 'net\dryuf\tenv\TestChild', null);
		\net\dryuf\tenv\DAssert::assertNotNull($meta->getPathField("svalue")->getReferenceDef());
	}
};


?>
