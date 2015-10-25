<?php

namespace net\dryuf\transaction;


interface TransactionHandler extends \java\lang\AutoCloseable
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			commit();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			rollback();

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			getRollbackOnly();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setRollbackOnly();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			close();
};


?>
