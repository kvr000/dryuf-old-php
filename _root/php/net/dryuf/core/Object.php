<?php

namespace net\dryuf\core;


class Object
{
	public function			__construct()
	{
	}

	public function			equals($compared)
	{
		return $this == $compared;
	}

	public function			hashCode()
	{
		return hexdec(substr(\spl_object_hash($this), -8, 0));
	}

	public function			__toString()
	{
		return $this->toString();
	}

	public function			toString()
	{
		return get_class($this)."@".$this->hashCode();
	}
};


?>
