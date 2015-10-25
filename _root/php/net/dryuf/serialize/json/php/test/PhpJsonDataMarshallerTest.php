<?php

namespace net\dryuf\serialize\json\php\test;


class PhpJsonDataMarshallerTest extends \net\dryuf\core\Object
{
	/**
	*/
	public function			__construct()
	{
		parent::__construct();

		$this->marshaller = new \net\dryuf\serialize\json\php\PhpJsonDataMarshaller();
	}

	protected function		marshalToString($obj)
	{
		$stream = \net\dryuf\io\IoUtil::openMemoryStream("");
		$this->marshaller->marshal($stream, $obj);
		rewind($stream);
		return stream_get_contents($stream);
	}

	protected function		unmarshalFromString($str, $clazz)
	{
		return $this->marshaller->unmarshal(\net\dryuf\io\IoUtil::openMemoryStream($str), $clazz);
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testMarshallingScalar()
	{
		\net\dryuf\tenv\DAssert::assertEquals("1", $this->marshalToString(1));
		\net\dryuf\tenv\DAssert::assertEquals("\"1\"", $this->marshalToString("1"));
		\net\dryuf\tenv\DAssert::assertEquals("null", $this->marshalToString(null));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testMarshallingArray()
	{
		\net\dryuf\tenv\DAssert::assertEquals("[]", $this->marshalToString(array()));
		\net\dryuf\tenv\DAssert::assertEquals("[0,\"1\"]", $this->marshalToString(array(0, "1")));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testMarshallingList()
	{
		\net\dryuf\tenv\DAssert::assertEquals("[]", $this->marshalToString(\net\dryuf\util\LinkedList::createFromArray(array())));
		\net\dryuf\tenv\DAssert::assertEquals("[0,\"1\"]", $this->marshalToString(\net\dryuf\util\LinkedList::createFromArray(array(0, "1"))));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testMarshallingMap()
	{
		\net\dryuf\tenv\DAssert::assertEquals("{}", $this->marshalToString(new \stdClass()));
		\net\dryuf\tenv\DAssert::assertEquals("[0]", $this->marshalToString(\net\dryuf\util\Collections::singleton(0)));
		\net\dryuf\tenv\DAssert::assertEquals("{\"a\":0,\"b\":1}", $this->marshalToString(\net\dryuf\util\MapUtil::createStringNativeHashMap("a", 0, "b", 1)));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testMarshallingComplex()
	{
		\net\dryuf\tenv\DAssert::assertEquals("{\"a\":0,\"b\":\"1\",\"c\":[0,1],\"d\":{\"a\":0,\"b\":1}}", $this->marshalToString(
			\net\dryuf\util\MapUtil::createStringNativeHashMap(
				"a",		0,
				"b",		"1",
				"c",		\net\dryuf\util\LinkedList::createFromArray(array(
					0, 1
				)),
				"d",		\net\dryuf\util\MapUtil::createStringNativeHashMap(
					"a",		0,
					"b",		1
				)
			)
		));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testUnmarshallingScalar()
	{
		\net\dryuf\tenv\DAssert::assertEquals(true, $this->unmarshalFromString("true", 'java.lang.Boolean'));
		\net\dryuf\tenv\DAssert::assertEquals(1, $this->unmarshalFromString("1", 'java.lang.Integer'));
		\net\dryuf\tenv\DAssert::assertEquals("1", $this->unmarshalFromString("\"1\"", 'java.lang.String'));
		\net\dryuf\tenv\DAssert::assertEquals(null, $this->unmarshalFromString("null", 'java.lang.String'));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testUnmarshallingArray()
	{
		\net\dryuf\tenv\DAssert::assertArrayEquals(array(), $this->unmarshalFromString("[]", '[Ljava.lang.Object;'));
		\net\dryuf\tenv\DAssert::assertArrayEquals(array(0, "1"), $this->unmarshalFromString("[0,\"1\"]", '[Ljava.lang.Object;'));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testUnmarshallingList()
	{
		\net\dryuf\tenv\DAssert::assertInstanceOf('net\dryuf\util\Listable', $this->unmarshalFromString("[]", 'net\dryuf\util\Listable'));
		\net\dryuf\tenv\DAssert::assertArrayEquals(array(0, "1"), $this->unmarshalFromString("[0,\"1\"]", 'net\dryuf\util\Listable')->toArray());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testUnmarshallingMap()
	{
		\net\dryuf\tenv\DAssert::assertInstanceOf('net\dryuf\util\Map', $this->unmarshalFromString("{}", 'net\dryuf\util\Map'));
		$r = $this->unmarshalFromString("{\"a\":0,\"b\":\"1\"}", 'net\dryuf\util\Map');
		\net\dryuf\tenv\DAssert::assertEquals(2, $r->size());
		\net\dryuf\tenv\DAssert::assertEquals(0, $r->get("a"));
		\net\dryuf\tenv\DAssert::assertEquals("1", $r->get("b"));
	}
};


?>
