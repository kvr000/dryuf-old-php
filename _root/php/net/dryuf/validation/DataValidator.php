<?php

namespace net\dryuf\validation;


interface DataValidator
{
	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	function			validate($callerContext, $errors);
};


?>
