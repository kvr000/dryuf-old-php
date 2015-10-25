<?php

namespace net\dryuf\oper\ObjectOperController;


class SimpleListContainer extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<java\lang\Object>')
	*/
	public				$entities;

	/**
	*/
	function			__construct($entities)
	{
		parent::__construct();
		$this->entities = $entities;
	}
};


?>
