<?php

namespace net\dryuf\process\command;


interface GetOptions
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			parseArguments($callerContext, $options, $args);
};


?>
