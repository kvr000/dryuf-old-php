<?php

namespace net\dryuf\parse\test;


class BinaryReaderTest extends \net\dryuf\core\Object
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
	public function			testLeInts()
	{
		\net\dryuf\tenv\DAssert::assertEquals(12, (new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 12 )))))->readLe8("byte"));
		\net\dryuf\tenv\DAssert::assertEquals(312, (new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 56, 1 )))))->readLe16("short"));
		\net\dryuf\tenv\DAssert::assertEquals(19770312, 
			(new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array(
					-56,
					-85,
					45,
					1
				)))))->readLe32("int"));
		\net\dryuf\tenv\DAssert::assertEquals(19770312022330, 
			(new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array(
					58,
					-39,
					108,
					34,
					-5,
					17,
					0,
					0
				)))))->readLe64("long"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testBeInts()
	{
		\net\dryuf\tenv\DAssert::assertEquals(12, (new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 12 )))))->readBe8("byte"));
		\net\dryuf\tenv\DAssert::assertEquals(312, (new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 1, 56 )))))->readBe16("short"));
		\net\dryuf\tenv\DAssert::assertEquals(19770312, 
			(new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array( 1, 45,
					-85,
					-56
				)))))->readBe32("int"));
		\net\dryuf\tenv\DAssert::assertEquals(19770312022330, 
			(new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array( 0, 0, 17,
					-5,
					34,
					108,
					-39,
					58
				)))))->readBe64("long"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testVarInts()
	{
		\net\dryuf\tenv\DAssert::assertEquals(12, (new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 12 )))))->readVarInt32("byte"));
		\net\dryuf\tenv\DAssert::assertEquals(19770312, 
			(new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array(
					(((((128+9))+0x80)&0xff)-0x80),
					(((((128+54))+0x80)&0xff)-0x80),
					(((((128+87))+0x80)&0xff)-0x80),
					72
				)))))->readVarInt32("int"));
		\net\dryuf\tenv\DAssert::assertEquals(19770312022330, 
			(new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array(
					(((((128+4))+0x80)&0xff)-0x80),
					(((((128+63))+0x80)&0xff)-0x80),
					(((((128+50))+0x80)&0xff)-0x80),
					(((((128+19))+0x80)&0xff)-0x80),
					(((((128+51))+0x80)&0xff)-0x80),
					(((((128+50))+0x80)&0xff)-0x80),
					58
				)))))->readVarInt64("long"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testString()
	{
		\net\dryuf\tenv\DAssert::assertEquals("hello", (new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( ord('h'), ord('e'), ord('l'), ord('l'), ord('o') )))))->readString(5, "string"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testHex()
	{
		\net\dryuf\tenv\DAssert::assertEquals("0123456789ABCDEF", 
			((new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array( 1, 35, 69, 103,
					-119,
					-85,
					-51,
					-17
				)))))->readBeHex(16, "string")));
		\net\dryuf\tenv\DAssert::assertEquals("FED", 
			((new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array(
					-2,
					-48
				)))))->readBeHex(3, "string")));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testVarString()
	{
		\net\dryuf\tenv\DAssert::assertEquals("hello", (new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 5, ord('h'), ord('e'), ord('l'), ord('l'), ord('o') )))))->readVarString(1000000, "string"));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testVarBytes()
	{
		\net\dryuf\tenv\DAssert::assertEquals("hello", ((new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 5, ord('h'), ord('e'), ord('l'), ord('l'), ord('o') )))))->readVarBytes(1000000, "string")));
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testFrpcs()
	{
		\net\dryuf\tenv\DAssert::assertEquals(19770312, 
			(new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array( 11,
					-56,
					-85,
					45,
					1
				)))))->readFrpcScalar("int"));
		\net\dryuf\tenv\DAssert::assertEquals(0, (new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 8, 0 )))))->readFrpcScalar("int"));
		\net\dryuf\tenv\DAssert::assertEquals(1.5, 
			(new \net\dryuf\parse\BinaryReader(
				implode(array_map('chr', array( 24, 0, 0, 0, 0, 0, 0,
					-8,
					63
				)))))->readFrpcScalar("int"));
		\net\dryuf\tenv\DAssert::assertEquals("hello", (new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 32, 5, ord('h'), ord('e'), ord('l'), ord('l'), ord('o') )))))->readFrpcScalar("string"));
		\net\dryuf\tenv\DAssert::assertEquals("hello", ((new \net\dryuf\parse\BinaryReader(implode(array_map('chr', array( 48, 5, ord('h'), ord('e'), ord('l'), ord('l'), ord('o') )))))->readFrpcScalar("string")));
	}
};


?>
