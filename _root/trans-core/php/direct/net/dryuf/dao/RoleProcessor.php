<?php

namespace net\dryuf\dao;


interface RoleProcessor
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			modifyQuery($query);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			modifyFilter($query);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	function			createEntityFromResult($result);
};


?>
