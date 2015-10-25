<?php

namespace net\dryuf\net\util;


class UrlUtil extends \net\dryuf\core\Object
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
	public static function		encodeUrl($path)
	{
		try {
			return urlencode($path);
		}
		catch (\java\io\UnsupportedEncodingException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		appendQuery($url, $query)
	{
		if (\net\dryuf\core\StringUtil::indexOf($url, '?') < 0)
			$url .= "?";
		elseif (substr($url, strlen($url)-1, 1) != '?' && substr($url, strlen($url)-1, 1) != '&')
			$url .= "&";
		return $url.$query;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		appendOptionalQuery($url, $query)
	{
		return (($query) == null) ? $url : \net\dryuf\net\util\UrlUtil::appendQuery($url, $query);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		appendParameter($url, $parameter, $value)
	{
		return \net\dryuf\net\util\UrlUtil::appendQuery($url, \net\dryuf\net\util\UrlUtil::encodeUrl($parameter)."=".\net\dryuf\net\util\UrlUtil::encodeUrl($value));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		buildQueryString($params)
	{
		$query = "?";
		foreach ($params->entrySet() as $entry) {
			$query = \net\dryuf\net\util\UrlUtil::appendParameter($query, $entry->getKey(), $entry->getValue());
		}
		return strval(substr($query, 1));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		getReversePath($url)
	{
		return \net\dryuf\core\StringUtil::replaceRegExp($url, ".+?/", "../");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		truncateToDir($url)
	{
		$end = \net\dryuf\core\StringUtil::indexOf($url, '?');
		if ($end < 0)
			$end = strlen($url);
		if (($p = \net\dryuf\core\StringUtil::lastIndexOf($url, '/', $end-1)) < 0)
			$p = -1;
		return strval(substr($url, 0, $p+1));
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public static function		truncateToParent($url)
	{
		$url = \net\dryuf\net\util\UrlUtil::truncateToDir($url);
		if (($p = \net\dryuf\core\StringUtil::lastIndexOf($url, '/', strlen($url)-2)) < 0)
			$p = $p-1;
		return strval(substr($url, 0, $p+1));
	}
};


?>
