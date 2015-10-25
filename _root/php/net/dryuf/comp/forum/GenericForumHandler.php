<?php

namespace net\dryuf\comp\forum;


abstract class GenericForumHandler extends \net\dryuf\core\Object implements \net\dryuf\comp\forum\ForumHandler
{
	/**
	*/
	function			__construct($callerContext)
	{
		parent::__construct();
		$this->callerContext = $callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getCallerContext()
	{
		return $this->callerContext;
	}
};


?>
