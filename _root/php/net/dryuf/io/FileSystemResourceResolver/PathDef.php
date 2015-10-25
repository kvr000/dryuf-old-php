<?php

namespace net\dryuf\io\FileSystemResourceResolver;


class PathDef extends \net\dryuf\core\Object
{
	/**
	*/
	function			__construct($prefix, $path)
	{
		parent::__construct();
		$this->prefix = $prefix;
		$this->path = $path;
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public				$prefix;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public				$path;
};


?>
