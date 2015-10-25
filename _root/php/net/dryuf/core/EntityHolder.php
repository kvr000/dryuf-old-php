<?php

namespace net\dryuf\core;


/**
 * Wrapping class for managing the entities data.
 * 
 * This wrapper contains reference to entity, related caller context and potentially dynamic view data.
 */
class EntityHolder extends \net\dryuf\core\Object
{
	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	*/
	function			__construct($entity_, $role_)
	{
		parent::__construct();
		$this->entity = $entity_;
		$this->role = $role_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public static function		createRoleOnly($role)
	{
		return new \net\dryuf\core\EntityHolder(null, $role);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityHolder<java\lang\Object>')
	*/
	public static function		createFull($entity, $role)
	{
		return new \net\dryuf\core\EntityHolder($entity, $role);
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			checkAccess($rolename)
	{
		return $this->role->checkRole($rolename);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public static function		getFrom($ent)
	{
		return !is_null($ent) ? $ent->getEntity() : null;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityView')
	*/
	public function			needView()
	{
		if (is_null($this->view))
			$this->view = new \net\dryuf\core\AbstractEntityView();
		return $this->view;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$entity;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getEntity()
	{
		return $this->entity;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setEntity($entity_)
	{
		$this->entity = $entity_;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$role;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getRole()
	{
		return $this->role;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityView')
	*/
	protected			$view;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\EntityView')
	*/
	public function			getView()
	{
		return $this->view;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setView($view_)
	{
		$this->view = $view_;
	}
};


?>
