<?php

namespace net\dryuf\parse;


class BinaryWriter extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->content = '';

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static function		createVarInt($number)
	{
		$buff = implode(array_map('chr', array_fill(0, 16, 0)));
		$i = strlen($buff);
		$buff[--$i] = chr(((((($number&127))+0x80)&0xff)-0x80));
		for ($number = ($number>>7)&9223372036854775807; $number != 0; $number >>= 7) {
			$buff[--$i] = chr(((((($number|128))+0x80)&0xff)-0x80));
		}
		return \net\dryuf\core\ByteUtil::subBytes($buff, $i);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeLe8($value)
	{
		$this->writeDirect(
			implode(array_map('chr', array(
				$value
			))));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeLe16($value)
	{
		$this->writeDirect(
			implode(array_map('chr', array(
				((((($value&255))+0x80)&0xff)-0x80),
				((((($value>>8))+0x80)&0xff)-0x80)
			))));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeLe32($value)
	{
		$this->writeDirect(
			implode(array_map('chr', array(
				((((($value>>0))+0x80)&0xff)-0x80),
				((((($value>>8))+0x80)&0xff)-0x80),
				((((($value>>16))+0x80)&0xff)-0x80),
				((((($value>>24))+0x80)&0xff)-0x80)
			))));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeLe64($value)
	{
		$this->writeDirect(
			implode(array_map('chr', array(
				((((($value>>0))+0x80)&0xff)-0x80),
				((((($value>>8))+0x80)&0xff)-0x80),
				((((($value>>16))+0x80)&0xff)-0x80),
				((((($value>>24))+0x80)&0xff)-0x80),
				((((($value>>32))+0x80)&0xff)-0x80),
				((((($value>>40))+0x80)&0xff)-0x80),
				((((($value>>48))+0x80)&0xff)-0x80),
				((((($value>>56))+0x80)&0xff)-0x80)
			))));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeBe8($value)
	{
		$this->writeDirect(
			implode(array_map('chr', array(
				$value
			))));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeBe16($value)
	{
		$this->writeDirect(
			implode(array_map('chr', array(
				((((($value>>8))+0x80)&0xff)-0x80),
				((((($value&255))+0x80)&0xff)-0x80)
			))));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeBe32($value)
	{
		$this->writeDirect(
			implode(array_map('chr', array(
				((((($value>>24))+0x80)&0xff)-0x80),
				((((($value>>16))+0x80)&0xff)-0x80),
				((((($value>>8))+0x80)&0xff)-0x80),
				((((($value>>0))+0x80)&0xff)-0x80)
			))));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeBe64($value)
	{
		$this->writeDirect(
			implode(array_map('chr', array(
				((((($value>>56))+0x80)&0xff)-0x80),
				((((($value>>48))+0x80)&0xff)-0x80),
				((((($value>>40))+0x80)&0xff)-0x80),
				((((($value>>32))+0x80)&0xff)-0x80),
				((((($value>>24))+0x80)&0xff)-0x80),
				((((($value>>16))+0x80)&0xff)-0x80),
				((((($value>>8))+0x80)&0xff)-0x80),
				((((($value>>0))+0x80)&0xff)-0x80)
			))));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeVarInt($number)
	{
		$this->writeDirect(\net\dryuf\parse\BinaryWriter::createVarInt($number));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeBytes($data)
	{
		$this->writeDirect($data);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeString($str)
	{
		$this->writeDirect($str);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte')
	*/
	public static function		convertHexCode($code)
	{
		switch ($code) {
		case '0':
		case '1':
		case '2':
		case '3':
		case '4':
		case '5':
		case '6':
		case '7':
		case '8':
		case '9':
			return (((((ord($code)-ord('0')))+0x80)&0xff)-0x80);

		case 'A':
		case 'B':
		case 'C':
		case 'D':
		case 'E':
		case 'F':
			return (((((ord($code)-(ord('A')-10)))+0x80)&0xff)-0x80);

		case 'a':
		case 'b':
		case 'c':
		case 'd':
		case 'e':
		case 'f':
			return (((((ord($code)-(ord('a')-10)))+0x80)&0xff)-0x80);

		default:
			throw new \net\dryuf\parse\ParseException("invalid hex code: ".$code);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeBeHex($hex)
	{
		for ($i = 0; $i < strlen($hex)-1; $i += 2) {
			$this->writeDirect(
				implode(array_map('chr', array(
					((((((\net\dryuf\parse\BinaryWriter::convertHexCode(substr($hex, $i, 1))<<4)|\net\dryuf\parse\BinaryWriter::convertHexCode(substr($hex, $i+1, 1))))+0x80)&0xff)-0x80)
				))));
		}
		if ($i < strlen($hex)) {
			$this->writeDirect(
				implode(array_map('chr', array(
					((((((\net\dryuf\parse\BinaryWriter::convertHexCode(substr($hex, $i, 1))<<4)))+0x80)&0xff)-0x80)
				))));
		}
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeVarBytes($data)
	{
		$this->writeVarInt(strlen($data));
		$this->writeDirect($data);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeVarString($data)
	{
		$this->writeVarBytes($data);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static function		createFrpcInt($type, $value)
	{
		for ($len = 7; $len < 63; $len += 8) {
			if (($value>>$len)+1 <= 1)
				break;
		}
		$data = implode(array_map('chr', \net\dryuf\core\Dryuf::allocArray(0, 2+intval($len/8))));
		$data[0] = chr(((((($type|(intval($len/8))))+0x80)&0xff)-0x80));
		for (++$len; ($len -= 8) >= 0; ) {
			$data[1+intval($len/8)] = chr(((((($value>>$len))+0x80)&0xff)-0x80));
		}
		return $data;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeFrpcInt($value)
	{
		$data = \net\dryuf\parse\BinaryWriter::createFrpcInt(8, $value);
		$this->writeDirect($data);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeFrpcDouble($value)
	{
		$this->writeDirect(implode(array_map('chr', array( 24 ))));
		$this->writeLe64((=f_I_x=)Double.doubleToLongBits(value)(=x_I_f=));
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeFrpcString($data)
	{
		$bytes = $data;
		$this->writeDirect(\net\dryuf\parse\BinaryWriter::createFrpcInt(32, strlen($bytes)));
		$this->writeDirect($bytes);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeFrpcBytes($data)
	{
		$this->writeDirect(\net\dryuf\parse\BinaryWriter::createFrpcInt(48, strlen($data)));
		$this->writeDirect($data);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryWriter')
	*/
	public function			writeDirect($data)
	{
		$this->content = \net\dryuf\core\ByteUtil::concatBytes($this->content, $data);
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			getContent()
	{
		return $this->content;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public				$content;
};


?>
