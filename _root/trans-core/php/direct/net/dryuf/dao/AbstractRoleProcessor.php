<?php

namespace net\dryuf\dao;


class AbstractRoleProcessor extends \net\dryuf\core\Object implements \net\dryuf\dao\RoleProcessor
{
	/**
	*/
	function			__construct($callerContext, $clazz)
	{
		parent::__construct();
		$this->callerContext = $callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			modifyQuery($query)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			modifyFilter($query)
	{
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public function			createEntityFromResult($result)
	{
		return new \net\dryuf\core\EntityHolder($result, $this->callerContext);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;
};


?>
