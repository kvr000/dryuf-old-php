<?php

namespace net\dryuf\comp\gallery;


abstract class GenericGalleryHandler extends \net\dryuf\core\Object implements \net\dryuf\comp\gallery\GalleryHandler
{
	/**
	*/
	function			__construct($callerContext)
	{
		parent::__construct();
		$this->callerContext = $callerContext;
	}

	/**
	@\net\dryuf\core\Type(type = 'int')
	*/
	public function			supportsResource($name)
	{
		return 0;
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadResourceData($name, $input)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("uploadResourceData not supported");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getResourceData($name)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("getResourceData not supported");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			cleanGallery()
	{
		throw new \net\dryuf\core\UnsupportedOperationException("getResourceData not supported");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	protected			$callerContext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\core\CallerContext')
	*/
	public function			getCallerContext()
	{
		return $this->callerContext;
	}
};


?>
