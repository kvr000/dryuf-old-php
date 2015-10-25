<?php

namespace net\dryuf\config;


interface IniConfig
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getValueMandatory($section, $name);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getValueDefault($section, $name, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getTextualMandatory($section, $name, $textual);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getTextualDefault($section, $name, $textual, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\config\ValueConfig')
	*/
	function			getSection($section);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	function			listSectionKeys($section);
};


?>
