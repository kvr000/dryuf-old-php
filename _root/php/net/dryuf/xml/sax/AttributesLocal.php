<?php

namespace net\dryuf\xml\sax;


class AttributesLocal extends \net\dryuf\core\Object
{
	/**
	*/
	public function			__construct($phpMap)
	{
		parent::__construct();
		$this->attributes = $phpMap;
	}

	public function			getValue($name)
	{
		return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
	}
};


?>
