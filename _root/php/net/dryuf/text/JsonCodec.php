<?php

namespace net\dryuf\text;


class JsonCodec extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		encode($value)
	{
		return json_encode($value);
	}
};


?>
