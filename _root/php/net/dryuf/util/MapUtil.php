<?php

namespace net\dryuf\util;


/**
 * Map utilities.
 */
class MapUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		getMapMandatory($map, $key)
	{
		if (is_null(($v = $map->get($key)))) {
			if (!$map->containsKey($key))
				throw new \net\dryuf\core\IllegalArgumentException(strval($key)." not found");
		}
		return $v;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\Object, java\lang\Object>')
	*/
	public static function		createHashMap()
	{
		$hash = new \net\dryuf\util\HashMap();
		$args = func_get_args();
		for ($i = 0; $i < count($args); $i += 2)
			$hash->put($args[$i], $args[$i+1]);
		return $hash;
	}


	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedHashMap<java\lang\Object, java\lang\Object>')
	*/
	public static function		createLinkedHashMap()
	{
		$hash = new \net\dryuf\util\LinkedHashMap();
		$args = func_get_args();
		for ($i = 0; $i < count($args); $i += 2)
			$hash->put($args[$i], $args[$i+1]);
		return $hash;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedHashMap<java\lang\String, java\lang\Object>')
	*/
	public static function		createNativeHashMap()
	{
		$hash = new \net\dryuf\util\php\NativeHashMap();
		$args = func_get_args();
		for ($i = 0; $i < count($args); $i += 2)
			$hash->put($args[$i], $args[$i+1]);
		return $hash;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedHashMap<java\lang\String, java\lang\Object>')
	*/
	public static function		createStringNativeHashMap()
	{
		$hash = new \net\dryuf\util\php\StringNativeHashMap();
		$args = func_get_args();
		for ($i = 0; $i < count($args); $i += 2)
			$hash->put($args[$i], $args[$i+1]);
		return $hash;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\util\function\Function<java\lang\Object, java\lang\Object>')
	*/
	public static			$notFoundFunction;

	public static function		_initManualStatic()
	{
		self::$notFoundFunction = function ($key) {
			throw new \net\dryuf\core\IllegalArgumentException(strval($key)." not found");
		}
		;
		self::$EMPTY_MAP = new \net\dryuf\util\php\NativeHashMap();
	}

	public static			$EMPTY_MAP;
};

\net\dryuf\util\MapUtil::_initManualStatic();


?>
