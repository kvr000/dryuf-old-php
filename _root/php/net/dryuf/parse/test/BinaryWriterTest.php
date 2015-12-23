<?php

namespace net\dryuf\parse\test;


class BinaryWriterTest extends \net\dryuf\core\Object
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
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 12 ))), (new \net\dryuf\parse\BinaryWriter())->writeLe8(12)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 56, 1 ))), (new \net\dryuf\parse\BinaryWriter())->writeLe16(312)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				-56,
				-85,
				45,
				1
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeLe32(19770312)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				58,
				-39,
				108,
				34,
				-5,
				17,
				0,
				0
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeLe64(19770312022330)->getContent());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testBeInts()
	{
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 12 ))), (new \net\dryuf\parse\BinaryWriter())->writeBe8(12)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 1, 56 ))), (new \net\dryuf\parse\BinaryWriter())->writeBe16(312)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array( 1, 45,
				-85,
				-56
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeBe32(19770312)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array( 0, 0, 17,
				-5,
				34,
				108,
				-39,
				58
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeBe64(19770312022330)->getContent());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testBerInts()
	{
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 12 ))), (new \net\dryuf\parse\BinaryWriter())->writeBerInt(12)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				(((((128+9))+0x80)&0xff)-0x80),
				(((((128+54))+0x80)&0xff)-0x80),
				(((((128+87))+0x80)&0xff)-0x80),
				72
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeBerInt(19770312)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				(((((128+4))+0x80)&0xff)-0x80),
				(((((128+63))+0x80)&0xff)-0x80),
				(((((128+50))+0x80)&0xff)-0x80),
				(((((128+19))+0x80)&0xff)-0x80),
				(((((128+51))+0x80)&0xff)-0x80),
				(((((128+50))+0x80)&0xff)-0x80),
				58
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeBerInt(19770312022330)->getContent());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testPbufInts()
	{
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 12 ))), (new \net\dryuf\parse\BinaryWriter())->writePbufInt32(12)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				(((((128+72))+0x80)&0xff)-0x80),
				(((((128+87))+0x80)&0xff)-0x80),
				(((((128+54))+0x80)&0xff)-0x80),
				9
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writePbufInt32(19770312)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				(((((128+58))+0x80)&0xff)-0x80),
				(((((128+50))+0x80)&0xff)-0x80),
				(((((128+51))+0x80)&0xff)-0x80),
				(((((128+19))+0x80)&0xff)-0x80),
				(((((128+50))+0x80)&0xff)-0x80),
				(((((128+63))+0x80)&0xff)-0x80),
				4
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writePbufInt64(19770312022330)->getContent());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testZigZagInts()
	{
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 24 ))), (new \net\dryuf\parse\BinaryWriter())->writeZigZagInt(12)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				(((((128+16))+0x80)&0xff)-0x80),
				(((((128+47))+0x80)&0xff)-0x80),
				(((((128+109))+0x80)&0xff)-0x80),
				18
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeZigZagInt(19770312)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				(((((128+116))+0x80)&0xff)-0x80),
				(((((128+100))+0x80)&0xff)-0x80),
				(((((128+102))+0x80)&0xff)-0x80),
				(((((128+38))+0x80)&0xff)-0x80),
				(((((128+100))+0x80)&0xff)-0x80),
				(((((128+126))+0x80)&0xff)-0x80),
				8
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeZigZagInt(19770312022330)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 1 ))), (new \net\dryuf\parse\BinaryWriter())->writeZigZagInt(-1)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				(((((128+127))+0x80)&0xff)-0x80),
				(((((1))+0x80)&0xff)-0x80)
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeZigZagInt(-128)->getContent());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testString()
	{
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( ord('h'), ord('e'), ord('l'), ord('l'), ord('o') ))), (new \net\dryuf\parse\BinaryWriter())->writeString("hello")->getContent());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testHex()
	{
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array( 1, 35, 69, 103,
				-119,
				-85,
				-51,
				-17
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeBeHex("0123456789ABCDEF")->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array(
				-2,
				-48
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeBeHex("FED")->getContent());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testVarString()
	{
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 5, ord('h'), ord('e'), ord('l'), ord('l'), ord('o') ))), (new \net\dryuf\parse\BinaryWriter())->writeVarString("hello")->getContent());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testVarBytes()
	{
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 5, ord('h'), ord('e'), ord('l'), ord('l'), ord('o') ))), (new \net\dryuf\parse\BinaryWriter())->writeVarBytes(implode(array_map('chr', array( ord('h'), ord('e'), ord('l'), ord('l'), ord('o') ))))->getContent());
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	@\org\junit\Test
	*/
	public function			testFrpcs()
	{
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array( 11,
				-56,
				-85,
				45,
				1
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeFrpcInt(19770312)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 8, 0 ))), (new \net\dryuf\parse\BinaryWriter())->writeFrpcInt(0)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(
			implode(array_map('chr', array( 24, 0, 0, 0, 0, 0, 0,
				-8,
				63
			))), 
			(new \net\dryuf\parse\BinaryWriter())->writeFrpcDouble(1.5)->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 32, 5, ord('h'), ord('e'), ord('l'), ord('l'), ord('o') ))), (new \net\dryuf\parse\BinaryWriter())->writeFrpcString("hello")->getContent());
		\net\dryuf\tenv\DAssert::assertEquals(implode(array_map('chr', array( 48, 5, ord('h'), ord('e'), ord('l'), ord('l'), ord('o') ))), (new \net\dryuf\parse\BinaryWriter())->writeFrpcBytes(implode(array_map('chr', array( ord('h'), ord('e'), ord('l'), ord('l'), ord('o') ))))->getContent());
	}
};


?>
