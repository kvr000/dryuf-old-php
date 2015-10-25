<?php

namespace net\dryuf\srvui;


interface Session
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			invalidate();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getSessionId();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			removeAttribute($name);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setAttribute($name, $value);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getAttribute($name);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getAttributeDefault($name, $defaultValue);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getAttributeTextual($name, $textual);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, java\lang\Object>')
	*/
	function			getAllAttributes();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setUserId($login);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\Object')
	*/
	function			getUserId();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			setUsername($name);

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getUsername();
};


?>
