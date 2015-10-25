<?php

namespace net\dryuf\comp\gallery;


abstract class ReadonlyGalleryHandler extends \net\dryuf\comp\gallery\GenericGalleryHandler
{
	/**
	*/
	function			__construct($callerContext, $galleryDir)
	{
		parent::__construct($callerContext);
		if (!(substr(($this->galleryDir = $galleryDir), -strlen("/")) == "/"))
			throw new \net\dryuf\core\RuntimeException("gallery path must end with '/'");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			addSection($section_info)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("addSection");
	}

	/**
	@\net\dryuf\core\Type(type = 'boolean')
	*/
	public function			addRecord($picture_info, $input)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("addRecord");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadRecordData($input)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("uploadRecordData not supported");
	}

	/**
	@\net\dryuf\core\Type(type = 'void')
	*/
	public function			uploadRecordThumb($input)
	{
		throw new \net\dryuf\core\UnsupportedOperationException("uploadRecordThumb not supported");
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getRecordData($record)
	{
		return $this->getCallerContext()->getBeanTyped("resourceResolver", 'net\dryuf\io\ResourceResolver')->getResource($this->galleryDir.$this->currentSectionName.$record->getDisplayName());
	}

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\io\FileData')
	*/
	public function			getRecordThumb($record)
	{
		return $this->getCallerContext()->getBeanTyped("resourceResolver", 'net\dryuf\io\ResourceResolver')->getResource($this->galleryDir.$this->currentSectionName.$this->currentThumb.$record->getDisplayName());
	}

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$galleryDir;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$currentSectionName = "";

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	protected			$currentThumb;
};


?>
