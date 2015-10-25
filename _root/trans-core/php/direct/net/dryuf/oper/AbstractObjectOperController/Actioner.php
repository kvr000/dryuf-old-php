<?php

namespace net\dryuf\oper\AbstractObjectOperController;


interface Actioner
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getActionName();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\oper\ObjectOperRules')
	*/
	function			getOperRules();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			runAction($controller, $operContext, $ownerHolder);
};


?>
