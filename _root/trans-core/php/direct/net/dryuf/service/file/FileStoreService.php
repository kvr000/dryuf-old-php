<?php

namespace net\dryuf\service\file;


interface FileStoreService
{
	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			putFile($path, $filename, $content);

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	function			getFile($path, $filename);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			removeFile($path, $filename);

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	function			removePath($path);
};


?>
