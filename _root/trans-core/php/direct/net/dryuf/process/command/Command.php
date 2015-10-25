<?php

namespace net\dryuf\process\command;


interface Command
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setCommandRunner($commandRunner);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			parseArguments($args);

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			reportUsage($reason);

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	function			process();
};


?>
