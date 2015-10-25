<?php

namespace net\dryuf\dao;


class GuestReadAdminUpdateRoleProcessor extends \net\dryuf\dao\AbstractRoleProcessor
{
	/**
	*/
	function			__construct($baseContext, $clazz)
	{
		parent::__construct($baseContext, $clazz);
		$this->callerContext = new \net\dryuf\core\RoleContext($this->callerContext);
		$baseName = \org\springframework\util\ClassUtils::getShortName($clazz);
		$this->callerContext->getRoles()->add($baseName.".read");
		if ($this->callerContext->checkRole("admin"))
			$this->callerContext->getRoles()->add($baseName.".update");
	}
};


?>
