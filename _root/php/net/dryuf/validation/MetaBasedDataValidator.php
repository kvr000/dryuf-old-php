<?php

namespace net\dryuf\validation;


class MetaBasedDataValidator extends \net\dryuf\core\Object implements \net\dryuf\validation\DataValidator
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			validate($callerContext, $errors)
	{
		return true;
	}
};


?>
