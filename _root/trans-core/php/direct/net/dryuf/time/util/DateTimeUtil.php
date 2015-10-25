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
	@\net\dryuf\core\Type(type = 'java\text\SimpleDateFormat')
	*/
	static				$DATE_UTC_ISO_FORMAT;

	/**
	@\net\dryuf\core\Type(type = 'java\text\SimpleDateFormat')
	*/
	static				$DATE_UTC_FORMAT;

	/**
	@\net\dryuf\core\Type(type = 'java\text\SimpleDateFormat')
	*/
	static				$DATE_LOCAL_FORMAT;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatLocalReadable($msecs)
	{
		return self::$DATE_UTC_ISO_FORMAT->format((=f_I_x=)new Date(msecs)(=x_I_f=));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatUtcReadable($msecs)
	{
		return self::$DATE_UTC_FORMAT->format((=f_I_x=)new Date(msecs)(=x_I_f=));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		formatUtcIso($epochMsecs)
	{
		return self::$DATE_UTC_ISO_FORMAT->format((=f_I_x=)new Date(epochMsecs)(=x_I_f=));
	}

	public static function		_initManualStatic()
	{
		self::$DATE_UTC_ISO_FORMAT = new \java\text\SimpleDateFormat("yyyy-MM-dd'T'HH:mm:ss'Z'");
		self::$DATE_UTC_FORMAT = new \java\text\SimpleDateFormat("yyyy-MM-dd HH:mm:ss z");
		self::$DATE_LOCAL_FORMAT = new \java\text\SimpleDateFormat("yyyy-MM-dd HH:mm:ss z");
		{
			self::$DATE_UTC_ISO_FORMAT->setTimeZone(\java\util\TimeZone::getTimeZone("UTC"));
			self::$DATE_UTC_FORMAT->setTimeZone(\java\util\TimeZone::getTimeZone("UTC"));
		}
	}

};

\net\dryuf\time\util\DateTimeUtil::_initManualStatic();


?>
