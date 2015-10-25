<?php

namespace net\dryuf\comp\gallery\MemoryGalleryHandler;


class GallerySectionMemory extends \net\dryuf\comp\gallery\GallerySection
{
	/**
	*/
	function			__construct()
	{
		$this->records = new \net\dryuf\util\LinkedList();
		$this->recordsHash = new \net\dryuf\util\php\StringNativeHashMap();

		parent::__construct();
	}

	/**
	@\net\dryuf\core\Type(type = 'long')
	*/
	const				serialVersionUID = 1;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Listable<net\dryuf\comp\gallery\GalleryRecord>')
	*/
	public				$records;

	/**
	@\net\dryuf\core\Type(type = 'net\dryuf\util\Map<java\lang\String, net\dryuf\comp\gallery\GalleryRecord>')
	*/
	public				$recordsHash;

	/**
	@\net\dryuf\core\Type(type = 'java\lang\String')
	*/
	public				$location;
};


?>
