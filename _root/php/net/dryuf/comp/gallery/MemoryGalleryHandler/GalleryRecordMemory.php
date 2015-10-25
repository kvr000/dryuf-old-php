<?php

namespace net\dryuf\comp\gallery\MemoryGalleryHandler;


class GalleryRecordMemory extends \net\dryuf\comp\gallery\GalleryRecord
{
	/**
	*/
	function			__construct()
	{
		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	public				$sectionPrevious;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	public				$sectionNext;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	public				$fullPrevious;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\comp\gallery\GalleryRecord')
	*/
	public				$fullNext;
};


?>
