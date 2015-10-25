<?php

namespace net\dryuf\oper\ObjectOperController;


class EntityContainer extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public				$entityHolder;

	/**
	*/
	function			__construct($entityHolder)
	{
		parent::__construct();
		$this->entityHolder = $entityHolder;
	}
};


?>
