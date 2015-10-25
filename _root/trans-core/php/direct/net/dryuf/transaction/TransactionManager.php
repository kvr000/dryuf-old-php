<?php

namespace net\dryuf\transaction;


interface TransactionManager
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\transaction\TransactionHandler')
	*/
	function			openTransaction($readOnly);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\transaction\TransactionHandler')
	*/
	function			keepContextTransaction($callerContext);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\RuntimeException')
	*/
	function			tryTranslateException($ex);
};


?>
