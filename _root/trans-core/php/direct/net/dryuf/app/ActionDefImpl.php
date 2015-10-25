<?php

namespace net\dryuf\app;


class ActionDefImpl extends \net\dryuf\core\Object implements \net\dryuf\meta\ActionDef
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$name;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			name()
	{
		return $this->name;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ActionDefImpl')
	*/
	public function			setName($name_)
	{
		$this->name = $name_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$isStatic = false;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			isStatic()
	{
		return $this->isStatic;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ActionDefImpl')
	*/
	public function			setIsStatic($isStatic_)
	{
		$this->isStatic = $isStatic_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$guiDef;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			guiDef()
	{
		return $this->guiDef;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ActionDefImpl')
	*/
	public function			setGuiDef($guiDef_)
	{
		$this->guiDef = $guiDef_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$formName;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formName()
	{
		return $this->formName;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ActionDefImpl')
	*/
	public function			setFormName($formName_)
	{
		$this->formName = $formName_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$formActioner;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			formActioner()
	{
		return $this->formActioner;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ActionDefImpl')
	*/
	public function			setFormActioner($formActioner_)
	{
		$this->formActioner = $formActioner_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$reqMode;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			reqMode()
	{
		return $this->reqMode;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ActionDefImpl')
	*/
	public function			setReqMode($reqMode_)
	{
		$this->reqMode = $reqMode_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$roleAction;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			roleAction()
	{
		return $this->roleAction;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ActionDefImpl')
	*/
	public function			setRoleAction($roleAction_)
	{
		$this->roleAction = $roleAction_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\annotation\Annotation>')
	*/
	public function			annotationType()
	{
		return 'net\dryuf\meta\ActionDef';
	}
};


?>
