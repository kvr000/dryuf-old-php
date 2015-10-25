<?php

namespace net\dryuf\service\logger;


interface MessageLogger
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			logMessage($category, $identifier);
};


?>
