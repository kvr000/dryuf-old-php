<?php

namespace net\dryuf\core;


/**
 * Conversion utilities among basic scalar types.
 */
abstract class ConversionUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Complex = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Null = 1;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Boolean = 2;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Character = 3;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Byte = 4;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Short = 5;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Int = 6;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Long = 7;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_String = 8;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Date = 9;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Set = 10;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_List = 11;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_Map = 12;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_CallerContext = 15;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_EntityHolder = 16;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	const				TC_EntityView = 17;

	/**
	 * Translates primitive type to its wrapper class. Returns null if passed class is not primitive.
	 * 
	 * @param orig
	 * 	original class
	 * 
	 * @return null
	 * 	if the passed argument is not primitive
	 * @return
	 * 	wrapper class for its primitive
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public static function		translatePrimitiveToWrap($orig)
	{
		return self::$primitiveMap->get($orig);
	}

	/**
	 * Translates primitive type to its wrapper class. Returns the original if passed class is not primitive.
	 * 
	 * @param orig
	 * 	original class
	 * 
	 * @return
	 * 	wrapper class for its primitive
	 */
	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public static function		translatePrimitiveToWrapOrOriginal($orig)
	{
		return self::$primitiveMap->getOrDefault($orig, $orig);
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public static function		getSerializableType($o)
	{
		if (is_null($o))
			return self::TC_Null;
		$c = get_class($o);
		if (is_null(($tc = self::$serializableTypes->get($c)))) {
			//$interfaces = (=f_I_x=)c.getInterfaces()(=x_I_f=);
			//if (count($interfaces) > 0 && !is_null(($tc = self::$serializableTypes->get($interfaces[0]))))
			//	return $tc;
			if ($o instanceof \net\dryuf\util\Set)
				return self::TC_Set;
			if ($o instanceof \net\dryuf\util\Listable)
				return self::TC_List;
			if ($o instanceof \net\dryuf\util\Map)
				return self::TC_Map;
			if ($o instanceof \net\dryuf\core\CallerContext)
				return self::TC_CallerContext;
			if ($o instanceof \net\dryuf\core\EntityHolder)
				return self::TC_EntityHolder;
			if ($o instanceof \net\dryuf\core\EntityView)
				return self::TC_EntityView;
			return self::TC_Complex;
		}
		return $tc;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public static function		isScalarClass($clazz)
	{
		switch ($clazz) {
		case 'bool':
		case 'boolean':
		case 'java.lang.Boolean':
		case 'java\lang\Boolean':
		case 'java.lang.Character':
		case 'java\lang\Character':
		case 'byte':
		case 'java.lang.Byte':
		case 'java\lang\Byte':
		case 'short':
		case 'java.lang.Short':
		case 'java\lang\Short':
		case 'int':
		case 'integer':
		case 'java.lang.Integer':
		case 'java\lang\Integer':
		case 'long':
		case 'java.lang.Long':
		case 'java\lang\Long':
		case 'float':
		case 'java.lang.Float':
		case 'java\lang\Float':
		case 'double':
		case 'java.lang.Double':
		case 'java\lang\Double':
		case 'java.lang.String':
		case 'java\lang\String':
			return true;

		default:
			return false;
		}
	}

	public static function		isNumberClass($clazz)
	{
		switch ($clazz) {
		case 'bool':
		case 'boolean':
		case 'byte':
		case 'short':
		case 'int':
		case 'integer':
		case 'long':
		case 'float':
		case 'double':
		case 'java.lang.Byte':
		case 'java.lang.Short':
		case 'java.lang.Integer':
		case 'java.lang.Long':
		case 'java.lang.Float':
		case 'java.lang.Double':
		case 'java\lang\Byte':
		case 'java\lang\Short':
		case 'java\lang\Integer':
		case 'java\lang\Long':
		case 'java\lang\Float':
		case 'java\lang\Double':
			return true;

		default:
			return false;
		}
	}

	public static function		isBooleanClass($clazz)
	{
		switch ($clazz) {
		case 'bool':
		case 'boolean':
		case 'java.lang.Boolean':
		case 'java\lang\Boolean':
			return true;

		default:
			return false;
		}
	}

	public static function		isStringClass($clazz)
	{
		switch ($clazz) {
		case 'string':
		case 'java.lang.String':
		case 'java\lang\String':
			return true;

		default:
			return false;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		convertToClass($target, $source)
	{
		if (is_null($source)) {
			return null;
		}
		elseif (\net\dryuf\core\Dryuf::getClass($source) == $target) {
			return $source;
		}
		elseif ((self::isNumberClass($target) || self::isBooleanClass($target)) && is_numeric($source)) {
			$number = $source;
			if ($target == 'java.lang.Integer' || $target == 'java\lang\Integer' || $target == 'int' || $target == 'integer')
				return intval($number);
			if ($target == 'java.lang.Long' || $target == 'java\lang\Long' || $target == 'long')
				return intval($number);
			if ($target == 'java.lang.Float' || $target == 'java\lang\Float' || $target == 'float')
				return floatval($number);
			if ($target == 'java.lang.Double' || $target == 'java\lang\Double' || $target == 'double')
				return doubleval($number);
			if ($target == 'java.lang.Short' || $target == 'java\lang\Short' || $target == 'short')
				return intval($number);
			if ($target == 'java.lang.Byte' || $target == 'java\lang\Byte' || $target == 'byte')
				return intval($number);
			if ($target == 'bool' || $target == 'boolean' || $target == 'java.lang.Boolean' || $target == 'java\lang\Boolean')
				return floatval($number) != 0;
			throw new \net\dryuf\core\RuntimeException("cannot convert ".\net\dryuf\core\Dryuf::getClass($number)." to ".$target);
		}
		elseif (self::isStringClass($target)) {
			return $source;
		}
		elseif (self::isBooleanClass($target)) {
			if ((strval($source) === "1") || (strval($source) === "true"))
				return \net\dryuf\core\Dryuf::convertBool(true);
			if ((strval($source) === "0") || (strval($source) === "false"))
				return \net\dryuf\core\Dryuf::convertBool(false);
			throw new \net\dryuf\core\RuntimeException("cannot convert value ".strval($source)." to boolean");
		}
		else {
			$result = \net\dryuf\core\Dryuf::createObjectArgs(\net\dryuf\core\Dryuf::getConstructor($target));
			$map = $source;
			foreach ($map->entrySet() as $entry) {
				$field = \net\dryuf\core\Dryuf::getClassField(\net\dryuf\core\Dryuf::getClass($result), $entry->getKey());
				\net\dryuf\core\Dryuf::setFieldValue($result, $field, \net\dryuf\core\ConversionUtil::convertToClass($field->getType(), $entry->getValue()));
			}
			return $result;
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		parseStringToClass($target, $source)
	{
		switch ($target) {
		case 'string':
		case 'java.lang.String':
		case 'java\lang\String':
			return $source;

		case 'boolean':
		case 'java.lang.Boolean':
		case 'java\lang\Boolean':
			return boolval($source);

		case 'byte':
		case 'java.lang.Byte':
		case 'java\lang\Byte':
		case 'short':
		case 'java.lang.Short':
		case 'java\lang\Short':
		case 'int':
		case 'integer':
		case 'java.lang.Integer':
		case 'java\lang\Integer':
		case 'long':
		case 'java.lang.Long':
		case 'java\lang\Long':
			return intval($source);

		case 'float':
		case 'double':
		case 'java.lang.Float':
		case 'java\lang\Float':
		case 'java.lang.Double':
		case 'java\lang\Double':
			return floatval($source);

		default:
			throw new \net\dryuf\core\RuntimeException("unknown conversion from string to ".$target);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\Class<java\lang\Object>, java\lang\Class<java\lang\Object>>')
	*/
	static				$primitiveMap;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\Class<java\lang\Object>, java\lang\Integer>')
	*/
	static				$serializableTypes;

	public static function		_initManualStatic()
	{
		self::$primitiveMap = \net\dryuf\util\MapUtil::createHashMap('boolean', 'java\lang\Boolean', 'char', 'java\lang\Character', 'byte', 'integer', 'short', 'integer', 'int', 'integer', 'long', 'integer', 'float', 'double', 'double', 'double');
		self::$serializableTypes = \net\dryuf\util\MapUtil::createHashMap('boolean', self::TC_Boolean, 'java\lang\Boolean', self::TC_Boolean, 'char', self::TC_Character, 'java\lang\Character', self::TC_Character, 'byte', self::TC_Byte, 'integer', self::TC_Byte, 'short', self::TC_Short, 'integer', self::TC_Short, 'int', self::TC_Int, 'integer', self::TC_Int, 'long', self::TC_Long, 'integer', self::TC_Long, 'string', self::TC_String, 'java\util\Date', self::TC_Date, 'net\dryuf\util\Set', self::TC_Set, 'net\dryuf\util\HashSet', self::TC_Set, 'java\util\TreeSet', self::TC_Set, 'net\dryuf\util\Listable', self::TC_List, 'net\dryuf\util\LinkedList', self::TC_List, 'net\dryuf\util\ArrayList', self::TC_List, 'net\dryuf\util\Map', self::TC_Map, 'net\dryuf\util\HashMap', self::TC_Map, 'java\util\TreeMap', self::TC_Map);
	}

};

\net\dryuf\core\ConversionUtil::_initManualStatic();


?>
