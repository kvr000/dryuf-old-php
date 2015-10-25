<?php

namespace net\dryuf\process\command;


interface CommandRunner
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	function			getCallerContext();

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			reportUsage($error, $usage);
};


?>
