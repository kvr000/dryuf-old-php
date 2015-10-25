<?php

namespace net\dryuf\io;


interface FileData
{
	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getName();

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			getSize();

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	function			getModifiedTime();

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	function			getContentType();

	/**
	@\net\dryuf\core\Type(type = 'java\io\InputStream')
	*/
	function			getInputStream();

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			close();
};


?>
