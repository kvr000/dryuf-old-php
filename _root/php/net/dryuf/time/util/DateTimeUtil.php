<?php

namespace net\dryuf\time\util;


class DateTimeUtil extends \net\dryuf\core\Object
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
	public static function		formatLocalReadable($msecs)
	{
		return strftime("%Y-%m-%d %H:%M:%S %Z", intval($msecs/1000));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatUtcReadable($msecs)
	{
		return gmstrftime("%Y-%m-%d %H:%M:%S UTC", intval($msecs/1000));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatUtcIso($epochMsecs)
	{
		return gmstrftime("%Y-%m-%dT%H:%M:%SZ", intval($epochMsecs/1000));
	}
};


?>
