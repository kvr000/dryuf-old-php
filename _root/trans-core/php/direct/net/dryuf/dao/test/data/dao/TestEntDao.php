<?php

namespace net\dryuf\dao\test\data\dao;


interface TestEntDao
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			update($obj);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			insert($obj);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			remove($obj);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Collection<net\dryuf\dao\test\data\TestEnt>')
	*/
	function			listAll();
};


?>
