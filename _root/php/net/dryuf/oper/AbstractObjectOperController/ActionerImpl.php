<?php

namespace net\dryuf\oper\AbstractObjectOperController;


class ActionerImpl implements \net\dryuf\oper\AbstractObjectOperController\Actioner
{
	function			__construct($actionName, $operRules, $callee)
	{
		$this->actionName = $actionName;
		$this->operRules = $operRules;
		$this->callee = $callee;

		if (is_null($operRules))
			throw new \net\dryuf\core\NullPointerException("operRules");
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getActionName()
	{
		return $this->actionName;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\oper\ObjectOperRules')
	*/
	function			getOperRules()
	{
		return $this->operRules;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			runAction($controller, $presenter, $ownerHolder)
	{
		return call_user_func($this->callee, $presenter, $ownerHolder);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$actionName;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\mvp\oper\ObjectOperRules')
	*/
	protected			$operRules;

	/**
	@\net\dryuf\core\Type(type = 'java\util\function\Function')
	*/
	protected			$callee;
};


?>
