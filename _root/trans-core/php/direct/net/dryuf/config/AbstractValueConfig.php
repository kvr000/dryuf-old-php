<?php

namespace net\dryuf\config;


class AbstractValueConfig extends \net\dryuf\core\Object implements \net\dryuf\config\ValueConfig
{
	/**
	*/
	function			__construct($iniConfig, $section)
	{
		parent::__construct();
		$this->iniConfig = $iniConfig;
		$this->section = $section;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getValueMandatory($name)
	{
		return $this->iniConfig->getValueMandatory($this->section, $name);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public function			getValueDefault($name, $defaultValue)
	{
		return $this->iniConfig->getValueDefault($this->section, $name, $defaultValue);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getTextualMandatory($name, $textual)
	{
		return $this->iniConfig->getTextualMandatory($this->section, $name, $textual);
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	public function			getTextualDefault($name, $textual, $defaultValue)
	{
		return $this->iniConfig->getTextualDefault($this->section, $name, $textual, $defaultValue);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	public function			keySet()
	{
		return $this->iniConfig->listSectionKeys($this->section);
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	public function			asMap()
	{
		$map = new \net\dryuf\util\php\StringNativeHashMap();
		foreach ($this->keySet() as $key)
			$map->put($key, $this->getValueMandatory($key));
		return $map;
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			equals($o)
	{
		if (!($o instanceof \net\dryuf\config\ValueConfig))
			return false;
		return \net\dryuf\core\Dryuf::equalObjects($this->keySet(), $o->asMap());
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			hashCode()
	{
		return \net\dryuf\core\Dryuf::hashCodeObject($this->asMap());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\IniConfig')
	*/
	protected			$iniConfig;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$section;
};


?>
