<?php

namespace net\dryuf\oper\ObjectOperController;


class ListContainer extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct()
	{
		$this->objects = new \net\dryuf\util\LinkedList();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	public				$total = 0;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\core\EntityHolder<java\lang\Object>>')
	*/
	public				$objects;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperController\ListContainer<java\lang\Object>')
	*/
	public static function		createFromList($callerContext, $entities)
	{
		$me = new \net\dryuf\oper\ObjectOperController\ListContainer();
		foreach ($entities as $e)
			$me->objects->add(new \net\dryuf\core\EntityHolder($e, $callerContext));
		return $me;
	}
};


?>
