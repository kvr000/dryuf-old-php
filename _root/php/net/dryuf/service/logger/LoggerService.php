<?php

namespace net\dryuf\service\logger;


interface LoggerService
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\service\logger\MessageLogger')
	*/
	function			getLogger($identifier);
};


?>
