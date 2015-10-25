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
			$rc->localRoles[$role] = 1;
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
			$rc->localRoles[$role] = 1;
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
				$newContext->localRoles[$mapping[$i]] = 1;
		}
		return $newContext;
	}

	/**
	*/
	function			__construct($parentContext)
	{
		$this->localRoles = array();

		parent::__construct($parentContext);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			checkRole($role)
	{
		return isset($this->localRoles[$role]) || $this->parentContext->checkRole($role);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			getRoles()
	{
		$all = new \net\dryuf\util\php\StringNativeHashSet();
		$all->addAll($this->parentContext->getRoles());
		$all->addAll($this->localRoles);
		return $all;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	protected			$localRoles;
};


?>
