<?php

namespace net\dryuf\config;


interface ValueConfig
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getValueMandatory($name);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getValueDefault($name, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getTextualMandatory($name, $textual);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getTextualDefault($name, $textual, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Set<java\lang\String>')
	*/
	function			keySet();

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\String>')
	*/
	function			asMap();
};


?>
