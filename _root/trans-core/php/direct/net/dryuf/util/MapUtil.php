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
	public static function		createHashMap($k0, $v0, $params)
	{
		$map = new \net\dryuf\util\HashMap();
		$map->put($k0, $v0);
		for ($i = 0; $i < count($params); ) {
			$k0 = $params[$i++];
			$v0 = $params[$i++];
			$map->put($k0, $v0);
		}
		return $map;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedHashMap<java\lang\Object, java\lang\Object>')
	*/
	public static function		createLinkedHashMap($k0, $v0, $params)
	{
		$map = new \net\dryuf\util\LinkedHashMap();
		$map->put($k0, $v0);
		for ($i = 0; $i < count($params); ) {
			$k0 = $params[$i++];
			$v0 = $params[$i++];
			$map->put($k0, $v0);
		}
		return $map;
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
	}

};

\net\dryuf\util\MapUtil::_initManualStatic();


?>
