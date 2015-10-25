<?php

namespace net\dryuf\core;


/**
 * Dummy implementation of CallerContext.
 */
class DummyCallerContext extends \net\dryuf\core\AbstractRootCallerContext
{
	/**
	*/
	function			__construct($appContainer)
	{
		parent::__construct($appContainer);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getUserId()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getRealUserId()
	{
		return null;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			checkRole($role)
	{
		return true;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			getRoles()
	{
		return new \net\dryuf\util\HashSet();
	}
};


?>
