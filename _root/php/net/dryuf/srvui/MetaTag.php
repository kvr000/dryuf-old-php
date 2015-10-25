<?php

namespace net\dryuf\srvui;


class MetaTag extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($type, $name, $content)
	{
		parent::__construct();
		$this->type = $type;
		$this->name = $name;
		$this->content = $content;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$type;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getType()
	{
		return $this->type;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setType($type_)
	{
		$this->type = $type_;
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
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setName($name_)
	{
		$this->name = $name_;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$content;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getContent()
	{
		return $this->content;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			setContent($content_)
	{
		$this->content = $content_;
	}
};


?>
