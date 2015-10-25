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
		$mapper = new \org\codehaus\jackson\map\ObjectMapper();
		try {
			$writer = new \java\io\StringWriter();
			$mapper->writeValue($writer, $value);
			return strval($writer);
		}
		catch (\net\dryuf\io\IoException $ex) {
			throw new \net\dryuf\core\RuntimeException($ex);
		}
	}
};


?>
