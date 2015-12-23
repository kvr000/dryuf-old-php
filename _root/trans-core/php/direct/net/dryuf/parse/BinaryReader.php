<?php

namespace net\dryuf\parse;


class BinaryReader extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($content_)
	{
		parent::__construct();
		$this->content = $content_;
		$this->pos = 0;
		$this->limit = strlen($this->content);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryReader')
	*/
	public static function		wrapWithLength($content, $length)
	{
		$self = new \net\dryuf\parse\BinaryReader($content);
		$self->limit = $length;
		return $self;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\parse\BinaryReader')
	*/
	public static function		wrapWithOffsetLength($content, $offset, $length)
	{
		$self = new \net\dryuf\parse\BinaryReader($content);
		$self->pos = $offset;
		$self->limit = $length;
		return $self;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			readBerInt32($name)
	{
		$number = 0;
		$ch = ord($this->content[$this->pos++]);
		while (($ch&128) != 0) {
			$number |= $ch&127;
			$number <<= 7;
			$ch = ord($this->content[$this->pos++]);
		}
		$number |= $ch;
		return $number;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			readPbufInt32($name)
	{
		$ch = ord($this->content[$this->pos++]);
		$number = $ch&127;
		for ($base = 7; ($ch&128) != 0; $base += 7) {
			$ch = ord($this->content[$this->pos++]);
			if ($base >= 28 && $ch >= 16)
				throw new \net\dryuf\core\IllegalArgumentException("Overflow while reading ".$name);
			$number |= (($ch&127)<<$base);
		}
		return $number;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			readZigZagInt32($name)
	{
		$n = $this->readPbufInt32($name);
		(=f_I_x= msg="Operator is unknown: >>>")return (-(n & 1)) ^ (n >>> 1);(=x_I_f=)
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			readBerInt64($name)
	{
		$number = 0;
		$ch = ord($this->content[$this->pos++]);
		while (($ch&128) != 0) {
			$number |= $ch&127;
			$number <<= 7;
			$ch = ord($this->content[$this->pos++]);
		}
		$number |= $ch;
		return $number;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			readPbufInt64($name)
	{
		$ch = ord($this->content[$this->pos++]);
		$number = $ch&127;
		for ($base = 7; ($ch&128) != 0; $base += 7) {
			$ch = ord($this->content[$this->pos++]);
			if ($base >= 63 && $ch >= 2)
				throw new \net\dryuf\core\IllegalArgumentException("Overflow while reading ".$name);
			$number |= (($ch&127)<<$base);
		}
		return $number;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			readZigZagInt64($name)
	{
		$n = $this->readPbufInt64($name);
		(=f_I_x= msg="Operator is unknown: >>>")return (-(n & 1)) ^ (n >>> 1);(=x_I_f=)
	}

	/**
	@\net\dryuf\core\Type(type = 'byte')
	*/
	public function			readLe8($name)
	{
		return ord($this->content[$this->pos++]);
	}

	/**
	@\net\dryuf\core\Type(type = 'byte')
	*/
	public function			readBe8($name)
	{
		return ord($this->content[$this->pos++]);
	}

	/**
	@\net\dryuf\core\Type(type = 'short')
	*/
	public function			readLe16($name)
	{
		$v = ((ord($this->content[$this->pos])&255)+((ord($this->content[$this->pos+1])&255)<<8));
		$this->pos += 2;
		return $v;
	}

	/**
	@\net\dryuf\core\Type(type = 'short')
	*/
	public function			readBe16($name)
	{
		$v = (((ord($this->content[$this->pos])&255)<<8)+((ord($this->content[$this->pos+1])&255)<<0));
		$this->pos += 2;
		return $v;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			readLe32($name)
	{
		$v = ((ord($this->content[$this->pos])&255)<<0)+((ord($this->content[$this->pos+1])&255)<<8)+((ord($this->content[$this->pos+2])&255)<<16)+((ord($this->content[$this->pos+3])&255)<<24);
		$this->pos += 4;
		return $v;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			readBe32($name)
	{
		$v = ((ord($this->content[$this->pos])&255)<<24)+((ord($this->content[$this->pos+1])&255)<<16)+((ord($this->content[$this->pos+2])&255)<<8)+((ord($this->content[$this->pos+3])&255)<<0);
		$this->pos += 4;
		return $v;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			readLe64($name)
	{
		$v = ((ord($this->content[$this->pos+0])&255)<<0)+((ord($this->content[$this->pos+1])&255)<<8)+((ord($this->content[$this->pos+2])&255)<<16)+((ord($this->content[$this->pos+3])&255)<<24)+((ord($this->content[$this->pos+4])&255)<<32)+((ord($this->content[$this->pos+5])&255)<<40)+((ord($this->content[$this->pos+6])&255)<<48)+((ord($this->content[$this->pos+7])&255)<<56);
		$this->pos += 8;
		return $v;
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public function			readBe64($name)
	{
		$v = ((ord($this->content[$this->pos+0])&255)<<56)+((ord($this->content[$this->pos+1])&255)<<48)+((ord($this->content[$this->pos+2])&255)<<40)+((ord($this->content[$this->pos+3])&255)<<32)+((ord($this->content[$this->pos+4])&255)<<24)+((ord($this->content[$this->pos+5])&255)<<16)+((ord($this->content[$this->pos+6])&255)<<8)+((ord($this->content[$this->pos+7])&255)<<0);
		$this->pos += 8;
		return $v;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			readBytes($length, $name)
	{
		$v = \net\dryuf\core\ByteUtil::subBytes($this->content, $this->pos, $length);
		$this->pos += $length;
		return $v;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			readString($length, $name)
	{
		return ($this->readBytes($length, $name));
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public static function		convertBeHex($b)
	{
		$f = (((((($b>>4)&15))+0x80)&0xff)-0x80);
		$s = (((((($b>>0)&15))+0x80)&0xff)-0x80);
		return implode(array_map('chr', array(
			$f < 10 ? (((((ord('0')+$f))+0x80)&0xff)-0x80) : (((((ord('A')+$f-10))+0x80)&0xff)-0x80),
			$s < 10 ? (((((ord('0')+$s))+0x80)&0xff)-0x80) : (((((ord('A')+$s-10))+0x80)&0xff)-0x80)
		)));
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			readBeHex($numHalfs, $name)
	{
		$o = implode(array_map('chr', \net\dryuf\core\Dryuf::allocArray(0, $numHalfs)));
		$p = 0;
		for (; $numHalfs >= 2; $numHalfs -= 2) {
			$b = $this->readLe8($name);
			$f = (((((($b>>4)&15))+0x80)&0xff)-0x80);
			$o[$p++] = chr($f < 10 ? (((((ord('0')+$f))+0x80)&0xff)-0x80) : (((((ord('A')+$f-10))+0x80)&0xff)-0x80));
			$s = (((((($b>>0)&15))+0x80)&0xff)-0x80);
			$o[$p++] = chr($s < 10 ? (((((ord('0')+$s))+0x80)&0xff)-0x80) : (((((ord('A')+$s-10))+0x80)&0xff)-0x80));
		}
		if ($numHalfs > 0) {
			$b = $this->readLe8($name);
			$f = (((((($b>>4)&15))+0x80)&0xff)-0x80);
			$o[$p++] = chr($f < 10 ? (((((ord('0')+$f))+0x80)&0xff)-0x80) : (((((ord('A')+$f-10))+0x80)&0xff)-0x80));
		}
		return $o;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			readVarBytes($max_size, $name)
	{
		$length = $this->readPbufInt32($name);
		if ($length > $max_size)
			throw new \net\dryuf\core\ArrayIndexOutOfBoundsException("length > max_size for ".$name);
		return $this->readBytes($length, $name);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			readVarString($max_size, $name)
	{
		return ($this->readVarBytes($max_size, $name));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			readFrpcScalar($name)
	{
		$type = $this->readLe8($name);
		switch ($type>>3) {
		case 1:
			{
				$last = 0;
				$value = 0;
				$type &= 7;
				for ($i = 0; $type-- >= 0; $i += 8) {
					$value += (($last = $this->readLe8($name))&255)<<$i;
				}
				if ($last < 0) {
					$value += -1<<$i;
				}
				return $value;
			}
			/* fall through */
		case 3:
			{
				return (=f_I_x=)Double.longBitsToDouble(readLe64(name))(=x_I_f=);
			}
			/* fall through */
		case 4:
			{
				$length = 0;
				$type &= 7;
				for ($i = 0; $type-- >= 0; $i += 8) {
					$length += $this->readLe8($name)<<$i;
				}
				return $this->readString($length, $name);
			}
			/* fall through */
		case 6:
			{
				$length = 0;
				$type &= 7;
				for ($i = 0; $type-- >= 0; $i += 8) {
					$length += $this->readLe8($name)<<$i;
				}
				return $this->readBytes($length, $name);
			}
			/* fall through */
		default:
			throw new \net\dryuf\core\UnsupportedOperationException("unknown FRPC scalar type: ".$type);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	public function			readRest($name)
	{
		return $this->readBytes($this->limit-$this->pos, $name);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getPos()
	{
		return $this->pos;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			isEnd()
	{
		return $this->pos == $this->limit;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getLength()
	{
		return $this->limit;
	}

	/**
	@\net\dryuf\core\Type(type = 'byte[]')
	*/
	protected			$content;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$pos = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$limit = 0;
};


?>
