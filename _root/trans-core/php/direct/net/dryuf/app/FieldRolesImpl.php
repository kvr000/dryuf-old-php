<?php

namespace net\dryuf\app;


class FieldRolesImpl extends \net\dryuf\core\Object implements \net\dryuf\meta\FieldRoles
{
	/**
	*/
	function			__construct($roleNew, $roleSet, $roleGet, $roleDel)
	{
		parent::__construct();
		$this->roleNew = $roleNew;
		$this->roleSet = $roleSet;
		$this->roleGet = $roleGet;
		$this->roleDel = $roleDel;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$roleNew;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			roleNew()
	{
		return $this->roleNew;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$roleSet;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			roleSet()
	{
		return $this->roleSet;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$roleGet;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			roleGet()
	{
		return $this->roleGet;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$roleDel;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			roleDel()
	{
		return $this->roleDel;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\annotation\Annotation>')
	*/
	public function			annotationType()
	{
		return 'net\dryuf\meta\FieldRoles';
	}
};


?>
