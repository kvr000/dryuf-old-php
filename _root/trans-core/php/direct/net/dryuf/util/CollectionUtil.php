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
	public static function		createHashSet($params)
	{
		$set = new \net\dryuf\util\HashSet();
		for ($i = 0; $i < count($params); ) {
			$set->add($params[$i++]);
		}
		return $set;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\Object>')
	*/
	public static function		createLinkedHashSet($params)
	{
		$set = new \net\dryuf\util\LinkedHashSet();
		for ($i = 0; $i < count($params); ) {
			$set->add($params[$i++]);
		}
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
