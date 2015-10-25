<?php

namespace net\dryuf\util;


/**
 * Map utilities.
 */
class CollectionUtil extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\Object>')
	*/
	public static function		createHashSet()
	{
		$set = new \net\dryuf\util\HashSet();
		$args = func_get_args();
		foreach ($args as $key)
			$set->add($key);
		return $set;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\LinkedHashSet<java\lang\Object>')
	*/
	public static function		createLinkedHashSet()
	{
		$set = new \net\dryuf\util\LinkedHashSet();
		$args = func_get_args();
		foreach ($args as $key)
			$set->add($key);
		return $set;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\Object>')
	*/
	public static function		createNativeHashSet()
	{
		$set = new \net\dryuf\util\php\NativeHashSet();
		$args = func_get_args();
		foreach ($args as $key)
			$set->add($key);
		return $set;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\Object>')
	*/
	public static function		createStringNativeHashSet()
	{
		$set = new \net\dryuf\util\php\NativeHashSet();
		$args = func_get_args();
		foreach ($args as $key)
			$set->add($key);
		return $set;
	}

	/**
	 * Sorts the passed and return the original list.
	 * 
	 * @param list
	 * 	items to be sorted
	 * @param comparator
	 * 	comparator to perform the sort
	 * @param <L>
	 *      list type
	 * @param <K>
	 *      element type
	 * @return
	 * 	the original sorted list
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\Object>')
	*/
	public static function		sortList($list, $comparator)
	{
		\net\dryuf\util\Collections::sort($list, $comparator);
		return $list;
	}
};


?>
