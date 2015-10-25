<?php

namespace net\dryuf\app;


class FieldDefImpl extends \net\dryuf\core\Object implements \net\dryuf\app\FieldDef
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getValue($o)
	{
		try {
			if (!is_null($this->getter))
				return (=f_I_x=)getter.invoke(o)(=x_I_f=);
			return (=f_I_x=)field.get(o)(=x_I_f=);
		}
		catch (\net\dryuf\core\IllegalArgumentException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		catch (\java\lang\IllegalAccessException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		catch (\java\lang\reflect\InvocationTargetException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setValue($o, $value)
	{
		try {
			if (!is_null($this->setter)) {
				(=f_I_x=)setter.invoke(o, value)(=x_I_f=);
				return;
			}
			(=f_I_x=)field.set(o, value)(=x_I_f=);
		}
		catch (\net\dryuf\core\IllegalArgumentException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		catch (\java\lang\IllegalAccessException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
		catch (\java\lang\reflect\InvocationTargetException $e) {
			throw new \net\dryuf\core\RuntimeException($e);
		}
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$name;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getName()
	{
		return $this->name;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setName($name_)
	{
		$this->name = $name_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$path;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getPath()
	{
		return $this->path;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setPath($path_)
	{
		$this->path = $path_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$type;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getType()
	{
		return $this->type;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setType($type_)
	{
		$this->type = $type_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$assocType = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getAssocType()
	{
		return $this->assocType;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setAssocType($assocType_)
	{
		$this->assocType = $assocType_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	protected			$embedded;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\ClassMeta<java\lang\Object>')
	*/
	public function			getEmbedded()
	{
		return $this->embedded;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setEmbedded($embedded_)
	{
		$this->embedded = $embedded_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$childClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getChildClass()
	{
		return $this->childClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setChildClass($childClass_)
	{
		$this->childClass = $childClass_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	protected			$assocClass;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<java\lang\Object>')
	*/
	public function			getAssocClass()
	{
		return $this->assocClass;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setAssocClass($assocClass_)
	{
		$this->assocClass = $assocClass_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<net\dryuf\core\Textual<java\lang\Object>>')
	*/
	protected			$textual;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<net\dryuf\core\Textual<java\lang\Object>>')
	*/
	public function			getTextual()
	{
		return $this->textual;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setTextual($textual_)
	{
		$this->textual = $textual_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Class<net\dryuf\core\Textual<java\lang\Object>>')
	*/
	public function			needTextual()
	{
		if (is_null($this->textual)) {
			throw new \net\dryuf\core\RuntimeException("textual undefined for ".$this->name);
		}
		return $this->textual;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	protected			$align = 0;

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			getAlign()
	{
		return $this->align;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setAlign($align_)
	{
		$this->align = $align_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$display;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getDisplay()
	{
		return $this->display;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setDisplay($display_)
	{
		$this->display = $display_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	protected			$mandatory = false;

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			getMandatory()
	{
		return $this->mandatory;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setMandatory($mandatory_)
	{
		$this->mandatory = $mandatory_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	protected			$doMandatory;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getDoMandatory()
	{
		return $this->doMandatory;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setDoMandatory($doMandatory_)
	{
		$this->doMandatory = $doMandatory_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\FieldRoles')
	*/
	protected			$roles;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\FieldRoles')
	*/
	public function			getRoles()
	{
		return $this->roles;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setRoles($roles_)
	{
		$this->roles = $roles_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ReferenceDef')
	*/
	protected			$referenceDef;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\meta\ReferenceDef')
	*/
	public function			getReferenceDef()
	{
		return $this->referenceDef;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setReferenceDef($referenceDef_)
	{
		$this->referenceDef = $referenceDef_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Field')
	*/
	protected			$field;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Field')
	*/
	public function			getField()
	{
		return $this->field;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setField($field_)
	{
		$this->field = $field_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	protected			$getter;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	public function			getGetter()
	{
		return $this->getter;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setGetter($getter_)
	{
		$this->getter = $getter_;
		return $this;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	protected			$setter;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\reflect\Method')
	*/
	public function			getSetter()
	{
		return $this->setter;
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\app\FieldDefImpl<java\lang\Object>')
	*/
	public function			setSetter($setter_)
	{
		$this->setter = $setter_;
		return $this;
	}
};


?>
