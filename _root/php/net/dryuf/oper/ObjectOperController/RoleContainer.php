<?php

namespace net\dryuf\oper\ObjectOperController;


class RoleContainer extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public				$roleContext;

	/**
	*/
	function			__construct($roleContext)
	{
		parent::__construct();
		$this->roleContext = $roleContext;
	}
};


?>
