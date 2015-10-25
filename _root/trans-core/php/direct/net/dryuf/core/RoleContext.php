<?php

namespace net\dryuf\core;


/**
 * Special implementation of CallerContext providing handy methods to amend the roles.
 */
class RoleContext extends \net\dryuf\core\SubCallerContext
{
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\RoleContext')
	*/
	public static function		createAdding($parentContext, $roles)
	{
		$rc = new \net\dryuf\core\RoleContext($parentContext);
		foreach ($roles as $role) {
			$rc->localRoles->add($role);
		}
		return $rc;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\RoleContext')
	*/
	public static function		createReplace($parentContext, $roles)
	{
		$rc = new \net\dryuf\core\RoleContext($parentContext);
		foreach ($roles as $role) {
			$rc->localRoles->add($role);
		}
		return $rc;
	}

	/**
	 * Creates new CallerContext with roles mapped according to mapping specification.
	 * 
	 * @param callerContext
	 * 	parent context
	 * @param mapping
	 * 	array of pairs, first of them defining new role and second specifying the dependent role
	 * 
	 * @return
	 * 	new role context
	 */
	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\RoleContext')
	*/
	public static function		createMapped($parentContext, $mapping)
	{
		$newContext = new \net\dryuf\core\RoleContext($parentContext);
		for ($i = 0; $i < count($mapping); $i += 2) {
			if ($parentContext->checkRole($mapping[$i+1]))
				$newContext->localRoles->add($mapping[$i]);
		}
		return $newContext;
	}

	/**
	*/
	function			__construct($parentContext)
	{
		$this->localRoles = new \net\dryuf\util\php\StringNativeHashSet();

		parent::__construct($parentContext);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			checkRole($role)
	{
		return $this->localRoles->contains($role) || $this->parentContext->checkRole($role);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			getRoles()
	{
		$this->localRoles->addAll($this->parentContext->getRoles());
		return $this->localRoles;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	protected			$localRoles;
};


?>
